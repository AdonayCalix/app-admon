<?php /** @noinspection SqlDialectInspection */

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\models\base\BatchMovement;
use app\modules\movement\models\Batch;
use app\modules\movement\models\MovementDetail;
use app\modules\project\models\base\Project;
use Mpdf\Tag\B;
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
                  and md.status is null
                  and project_id = {$project_id}
                  and kind in ('Egreso', 'Comision Bancaria');"
        )->queryAll();

        return json_encode($values);
    }

    public function actionGetModChecks(int $project_id)
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
                where md._listId is not null            
                  and md.status = 'Sucess'
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
                  and md.status is null
                  and project_id = {$project_id}
                  and kind in ('Ingreso', 'Desembolso')
                order by md.date;"
        )->queryAll();

        return json_encode($values);
    }

    public function actionGetModDeposits(int $project_id)
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
                where md._listId is not null
                  and md.status = 'Sucess'
                  and project_id = {$project_id}
                  and kind in ('Ingreso', 'Desembolso')
                order by md.date;"
        )->queryAll();

        return json_encode($values);
    }

    public function actionGetBatchInfo(int $project_id, string $kind)
    {
        $project = Project::findOne($project_id);

        $batch = Batch::find()
            ->where(['project_id' => $project_id]);

        $correlative = ['Egreso' => '01', 'Ingreso' => '02', 'Desembolso' => '03'];

        $batch_name = "{$project->alias}-{$correlative[$kind]}-" . str_pad(($batch->count() + 1), 4, '0', STR_PAD_LEFT);;

        return json_encode($batch_name);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionStore()
    {
        if (!Yii::$app->request->isAjax)
            throw new NotFoundHttpException;

        if (isset($_POST['kind_operation_id']) && $_POST['kind_operation_id'] === 'add') {
            MovementDetail::setStatusToProcess($_POST['Movements']);
            return json_encode(['success' => true]);
        }

        if (isset($_POST['kind_operation_id']) && $_POST['kind_operation_id'] === 'update') {
            MovementDetail::setStatusToModify($_POST['Movements']);
            return json_encode(['success' => true]);
        }

        Yii::$app->response->statusCode = 422;
        return json_encode(['error' => true]);
    }

    public function actionGetCheckMessage(int $project_id, string $batch_number)
    {
        $data = MovementDetail::getChecks($project_id, $batch_number);
        return json_encode($data);
    }

    public function actionGetDepositMessage(int $project_id, string $batch_number)
    {
        $data = MovementDetail::getDeposits($project_id, $batch_number);
        return json_encode($data);
    }

    public function actionShowAgain(): Response
    {
        Yii::$app->session->setFlash('success', 'Se cargo el lote de movimientos a registrar en el QB, continue el proceso desde la PC del QuickBook');
        return $this->redirect(['to-qb']);
    }

    public function actionVeamos()
    {
        MovementDetail::getChecks();
    }
}