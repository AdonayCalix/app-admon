<?php

namespace app\modules\expense\controllers;

use app\controllers\base\BaseController;
use Yii;
use app\modules\expense\models\AdvanceDetail;
use app\modules\expense\models\AdvanceDetailSearch;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * AdvanceDetailController implements the CRUD actions for AdvanceDetail model.
 */
class AdvanceDetailController extends BaseController
{
    /**
     * Lists all AdvanceDetail models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new AdvanceDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdvanceDetail model.
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
     * Creates a new AdvanceDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new AdvanceDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se creo correctamente el detalle de gasto');
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdvanceDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se actualizo correctamente el detalle de gasto');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdvanceDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->deleteWithRelated();
        Yii::$app->session->setFlash('success', 'Se elimino correctamente el detalle de gasto');
        return $this->redirect(['index']);
    }


    /**
     * Finds the AdvanceDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdvanceDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): AdvanceDetail
    {
        if (($model = AdvanceDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
