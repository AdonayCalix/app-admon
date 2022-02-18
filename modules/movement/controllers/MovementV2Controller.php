<?php

namespace app\modules\movement\controllers;

use app\modules\movement\components\CheckIfDateIsOutPeriod;
use app\modules\movement\components\LoadValuesV2;
use app\modules\movement\components\MoneyToWords;
use app\modules\movement\components\MovementWithDetailsV2;
use app\modules\movement\components\StoreValuesV2;
use app\modules\movement\components\vouchers\gf\VoucherDetailGlobalFund;
use app\modules\movement\components\LoadValues;
use app\modules\movement\components\MovementWithDetails;
use app\modules\movement\components\StoreValues;
use app\modules\movement\components\vouchers\gf\VoucherHeaderGlobalFund;
use app\modules\movement\components\vouchers\others\VoucherDetailOtherProject;
use app\modules\movement\components\vouchers\VoucherFile;
use app\modules\movement\models\MovementDetail;
use app\modules\project\components\HierachyActivityList;
use app\modules\project\models\Beneficiary;
use app\modules\project\models\Project;
use app\modules\project\models\ProjectPeriod;
use app\modules\qb\components\HierachyChartAccountList;
use app\modules\qb\components\HierarchyClassList;
use Luecano\NumeroALetras\NumeroALetras;
use Yii;
use app\modules\movement\models\Movement;
use app\modules\movement\models\MovementSearch;
use app\controllers\base\BaseController;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * MovementController implements the CRUD actions for Movement model.
 */
class MovementV2Controller extends BaseController
{
    public function actionOtherCreate()
    {
        Yii::$app->session->setFlash('success', 'Se guardo correctamente la reasignacion del movimiento V2');
        return $this->redirect(['movement/index']);
    }

    public function actionStoreBeneficiary()
    {
        $beneficiary = new Beneficiary;
        $beneficiary->name = $_POST['name'];
        $beneficiary->save(false);
        return true;
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionStore()
    {
        if (!Yii::$app->request->isAjax)
            throw new \yii\web\NotFoundHttpException;

        $loadValues = new LoadValuesV2(Yii::$app->request->post());
        $loadValues->initializeMovement()
            ->initializeDetails();

        if ($loadValues->hasErrors()) {
            Yii::$app->response->statusCode = 422;
            return json_encode($loadValues->getErrors());
        }

        (new StoreValuesV2($loadValues->getModels()))
            ->saveMovement()
            ->saveDetails()
            ->getStatus();

        return json_encode(['success' => true]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionReAssign($id, $has_v2): string
    {
        $model = $this->findModel($id);
        return $this->render('update', [
            'model' => $model,
            'has_v2' => $has_v2
        ]);
    }

    /**
     * Finds the Movement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Movement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Movement
    {
        if (($model = Movement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetAllClasses()
    {
        return json_encode((new HierarchyClassList())->setMainClasses()->setOptions()->get());
    }

    public function actionGetAllAccounts()
    {
        return json_encode((new HierachyChartAccountList())->setmainAccount()->setOptions()->get());
    }

    public function actionGetAllProject()
    {
        $projects = Project::find()
            ->select(['project.id', 'alias as label'])
            ->orderBy('id')
            ->asArray()
            ->all();
        return json_encode($projects);
    }

    public function actionGetAllActivities($project_id)
    {
        return json_encode((new HierachyActivityList($project_id))->setBudgets()->setOptions()->get());
    }

    public function actionGetAllBeneficiaries()
    {
        $beneficiaries = Beneficiary::find()
            ->select(["id", "name as label"])
            ->asArray()
            ->all();
        return json_encode($beneficiaries);
    }

    public function actionValidateDate($date, $projectId)
    {
        $result = [
            'isValid' => (new CheckIfDateIsOutPeriod($date, $projectId))
                ->setPeriodSuchCurrentDate()
                ->setPeriodSuchDate()
                ->result()
        ];

        return json_encode($result);
    }

    public function actionGetMovementsWithDetails($transfer_id, $has_v2)
    {
        return json_encode((new MovementWithDetailsV2($transfer_id, $has_v2))->make()->get());
    }
}
