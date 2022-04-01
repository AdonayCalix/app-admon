<?php /** @noinspection SqlDialectInspection */

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\models\MovementDetail;
use app\modules\project\models\base\Project;
use Yii;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ImportController extends BaseController
{
    public function actionToQb(): string
    {
        return $this->render('_import');
    }

    public function actionGetProjects()
    {
        return json_encode(Project::find()
            ->select(['project.id as id', 'project.alias as label'])
            ->orderBy('id')->asArray()->all());
    }

    /**
     * @throws Exception
     */
    public function actionGetChecks(int $project_id)
    {
        /** @noinspection SqlNoDataSourceInspection */
        $values = \Yii::$app->db->createCommand(
            "select md.id as id, 
                        movement.number as number,
                        format(md.amount, 'C', 'hn-HN') as amount,
                        format(md.date, 'dd/MM/yyyy')         as date
                from movement
                         join movement_detail md on movement.id = md.transfer_id
                         join project p on movement.project_id = p.id
                where md._listId is null
                  and project_id = {$project_id}
                  and kind in ('Egreso', 'Comision Bancaria');"
        )->queryAll();

        return json_encode($values);
    }

    /**
     * @throws Exception
     */
    public function actionGetDeposits(int $project_id)
    {
        /** @noinspection SqlNoDataSourceInspection */
        $values = \Yii::$app->db->createCommand(
            "select md.id as id, 
                        movement.number as number,
                        format(md.amount, 'C', 'hn-HN') as amount,
                        format(md.date, 'dd/MM/yyyy')         as date
                from movement
                         join movement_detail md on movement.id = md.transfer_id
                         join project p on movement.project_id = p.id
                where md._listId is null
                  and project_id = {$project_id}
                  and kind in ('Ingreso', 'Desembolso')
                order by md.date;"
        )->queryAll();

        return json_encode($values);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionStore()
    {
        if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException;

        if (MovementDetail::setStatusToProcess($_POST['Movements'])) {
            return json_encode(['success' => true]);
        } else {
            Yii::$app->response->statusCode = 422;
            return json_encode(['error' => true]);
        }
    }

    public function actionShowAgain(): Response
    {
        Yii::$app->session->setFlash('success', 'Se cargo el lote de movimientos a registrar en el QB, el proceso puede demorar entre 5-10 minutos');
        return $this->redirect(['to-qb']);
    }
}