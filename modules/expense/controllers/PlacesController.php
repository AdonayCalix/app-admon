<?php

namespace app\modules\expense\controllers;

use app\controllers\base\BaseController;
use Yii;
use app\modules\expense\models\Places;
use app\modules\expense\models\PlacesSearch;
use yii\db\Exception as ExceptionAlias;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * PlacesController implements the CRUD actions for Places model.
 */
class PlacesController extends BaseController
{
    /**
     * Lists all Places models.
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PlacesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Places model.
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
     * Creates a new Places model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws ExceptionAlias
     */
    public function actionCreate()
    {
        $model = new Places();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            Yii::$app->session->setFlash('success', 'Se creo correctamente el lugar de destino');
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Places model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws ExceptionAlias
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            Yii::$app->session->setFlash('success', 'Se actualizo correctamente el lugar de destino');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Places model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws ExceptionAlias
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();
        Yii::$app->session->setFlash('success', 'Se elimino el lugar de destino');
        return $this->redirect(['index']);
    }


    /**
     * Finds the Places model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Places the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Places
    {
        if (($model = Places::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
