<?php

namespace app\modules\project\controllers;

use Yii;
use app\modules\project\models\ProjectPeriod;
use app\modules\project\models\ProjectPeriodSearch;
use app\controllers\base\BaseController;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ProjectPeriodController implements the CRUD actions for ProjectPeriod model.
 */
class ProjectPeriodController extends BaseController
{
    /**
     * Lists all ProjectPeriod models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ProjectPeriodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderIsAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectPeriod model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $model = $this->findModel($id);
        return $this->renderIsAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProjectPeriod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new ProjectPeriod();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            Yii::$app->session->setFlash('success', 'Se creo correctamente el periodo de ejecucion');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderIsAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectPeriod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se actualizo correctamente el periodo de ejecucion');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderIsAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectPeriod model.
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
     * Finds the ProjectPeriod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectPeriod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): ProjectPeriod
    {
        if (($model = ProjectPeriod::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
