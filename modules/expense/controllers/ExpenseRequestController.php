<?php

namespace app\modules\expense\controllers;

use app\controllers\base\BaseController;
use app\modules\expense\components\ExpenseRequestFile;
use app\modules\expense\models\AdvanceDetail;
use app\modules\expense\models\ExpenseRequestDetail;
use app\modules\expense\models\FoodExpenseRequest;
use app\modules\expense\models\Places;
use app\modules\movement\components\receipt\ReceiptFile;
use app\modules\movement\models\base\TransferAssignment;
use app\modules\project\models\Beneficiary;
use PhpOffice\PhpSpreadsheet\Calculation\Engineering\ErfC;
use Yii;
use app\modules\expense\models\ExpenseRequest;
use app\modules\expense\models\ExpenseRequestSearch;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ExpenseRequestController implements the CRUD actions for ExpenseRequest model.
 */
class ExpenseRequestController extends BaseController
{

    /**
     * Lists all ExpenseRequest models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ExpenseRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExpenseRequest model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $model = $this->findModel($id);
        $providerExpenseRequestDetail = new \yii\data\ArrayDataProvider([
            'allModels' => $model->expenseRequestDetails,
        ]);
        $providerFoodExpenseRequest = new \yii\data\ArrayDataProvider([
            'allModels' => $model->foodExpenseRequests,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerExpenseRequestDetail' => $providerExpenseRequestDetail,
            'providerFoodExpenseRequest' => $providerFoodExpenseRequest
        ]);
    }

    /**
     * Creates a new ExpenseRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new ExpenseRequest();
        $model->loadPreviosExpenseRequest();

        if ($model->loadAll(Yii::$app->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ExpenseRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return string|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionStore()
    {
        if (!Yii::$app->request->isAjax)
            throw new \yii\web\NotFoundHttpException;

        $expense_request = ExpenseRequest::findOne($_POST['ExpenseRequest']['id'] ?? null) ?? new ExpenseRequest();

        if ($expense_request->loadAll($_POST) && $expense_request->saveAll()) {
            TransferAssignment::store($expense_request);
            return json_encode(['success' => true, 'id' => $expense_request->id]);
        } else {
            Yii::$app->response->statusCode = 422;
            return json_encode($expense_request->errors);
        }

    }

    public function actionOtherCreate($id): Response
    {
        Yii::$app->session->setFlash('success', 'Se guardo correctamente la solicitud de anticipo de gasto');
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing ExpenseRequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExpenseRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExpenseRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): ExpenseRequest
    {
        if (($model = ExpenseRequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetAdvanceDetail()
    {
        $advance_details = AdvanceDetail::find()
            ->select(['id', 'name as label'])
            ->andWhere(['<>', 'name', 'Alimentación'])
            ->orderBy(['name' => SORT_ASC])
            ->asArray()
            ->all();

        return json_encode($advance_details);
    }

    public function actionGetAllBeneficiaries()
    {
        $beneficiaries = Beneficiary::find()
            ->select(["id", "name as label"])
            ->asArray()
            ->all();
        return json_encode($beneficiaries);
    }

    public function actionGetAllPlaces()
    {
        $places = Places::find()
            ->select(['id', 'name as label'])
            ->asArray()
            ->all();

        return json_encode($places);
    }

    public function actionGetAllFoodExpense($id)
    {
        $food_expense_requests = FoodExpenseRequest::find()
            ->select(['id', 'date', 'place_id', 'breakfast', 'lunch', 'dinner'])
            ->where(['expense_request_id' => $id])
            ->asArray()
            ->all();

        return json_encode($food_expense_requests);
    }

    public function actionGetAllAdvanceDetail($id)
    {
        $expense_request_details = ExpenseRequestDetail::find()
            ->select(['id', 'advance_detail_id as expense_id', 'amount'])
            ->where(['expense_request_id' => $id])
            ->asArray()
            ->all();

        return json_encode($expense_request_details);
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function actionGetFile($expense_request_id)
    {
        (new ExpenseRequestFile($expense_request_id))
            ->initializeExcel()
            ->setHeader()
            ->setDetails()
            ->downloadFile();
    }

    public function actionGetReceipt($id)
    {
        (new ReceiptFile($id))
            ->initializeExcel()
            ->writeContent()
            ->downloadFile('RECIBO.xlsx');
    }

    public function actionStoreNewExpense(): bool
    {
        $advanceDetail = new AdvanceDetail;
        $advanceDetail->name = $_POST['name'];
        $advanceDetail->save(false);
        return true;
    }

    public function actionStoreNewPlace(): bool
    {
        $places = new Places;
        $places->name = $_POST['name'];
        $places->save(false);
        return true;
    }

}
