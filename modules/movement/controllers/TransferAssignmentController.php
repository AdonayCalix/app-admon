<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\project\models\Beneficiary;
use Yii;
use app\modules\movement\models\TransferAssignment;
use app\modules\movement\models\TransferAssignmentSearch;
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
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new TransferAssignment();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TransferAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
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
}
