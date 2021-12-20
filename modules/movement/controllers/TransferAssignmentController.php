<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\components\LoadTransferAssignment;
use app\modules\movement\components\receipt\ReceiptFile;
use app\modules\movement\components\StoreTransferAssignment;
use app\modules\movement\models\Movement;
use app\modules\project\models\Beneficiary;
use app\modules\project\models\Position;
use Yii;
use app\modules\movement\models\TransferAssignment;
use app\modules\movement\models\TransferAssignmentSearch;
use yii\base\DynamicModel;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TransferAssignmentController implements the CRUD actions for TransferAssignment model.
 */
class TransferAssignmentController extends BaseController
{
    /**
     * Lists all TransferAssignment models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new TransferAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TransferAssignment model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TransferAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string
     */
    public function actionCreate(): string
    {
        $model = new DynamicModel(['transfer_id']);
        $model->addRule(['transfer_id'], 'required', ['message' => 'Debes de indicar el numero de la TB/Cheque']);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TransferAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     */
    public function actionUpdate($id)
    {
        $model = new DynamicModel(['transfer_id']);
        $model->addRule(['transfer_id'], 'required', ['message' => 'Debes de indicar el numero de la TB/Cheque']);
        $model->transfer_id = $id;

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TransferAssignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException|Exception
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionStore()
    {
        if (!Yii::$app->request->isAjax)
            throw new \yii\web\NotFoundHttpException;

        $loadValues = new LoadTransferAssignment(Yii::$app->request->post());
        $loadValues
            ->initialize()
            ->initializeAssign();

        if ($loadValues->hasErrors()) {
            Yii::$app->response->statusCode = 422;
            return json_encode($loadValues->getErrors());
        }

        (new StoreTransferAssignment($loadValues->getModels()))
            ->saveAssignments()
            ->getStatus();

        return json_encode(['success' => true]);
    }

    /**
     * Finds the TransferAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TransferAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): TransferAssignment
    {
        if (($model = TransferAssignment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetAllBeneficiaries()
    {
        $beneficiaries = Beneficiary::find()
            ->select(["id", "name as label"])
            ->asArray()
            ->all();
        return json_encode($beneficiaries);
    }

    public function actionGetAllPositions()
    {
        return json_encode(Position::get());
    }

    public function actionGetAllTransfers()
    {
        return json_encode(Movement::getAll());
    }

    public function actionGetTransferAssignments($transfer_id)
    {
        return json_encode(TransferAssignment::getAll($transfer_id));
    }

    public function actionGetReceipt($id)
    {
        (new ReceiptFile($id))
            ->initializeExcel()
            ->writeContent()
            ->downloadFile('RECIBO.xlsx');
    }
}
