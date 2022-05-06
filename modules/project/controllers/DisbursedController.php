<?php

namespace app\modules\project\controllers;

use app\controllers\base\BaseController;
use app\modules\project\models\ProjectPeriod;
use Yii;
use app\modules\project\models\Disbursed;
use app\modules\project\models\DisbursedSearch;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * DisbursedController implements the CRUD actions for Disbursed model.
 */
class DisbursedController extends BaseController
{
    /**
     * Lists all Disbursed models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new DisbursedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Disbursed model.
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
     * Creates a new Disbursed model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Disbursed();

        if ($model->load(Yii::$app->request->post()) && $model->saveMovement()) {
            Yii::$app->session->setFlash('success', 'Se creo correctamente el desembolso para el proyecto');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Disbursed model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        echo '<pre>' . print_r($_POST, true) . '</pre>';die;
        if ($model->load(Yii::$app->request->post()) && $model->saveMovement()) {
            Yii::$app->session->setFlash('success', 'Se actualizo correctamente el desembolso');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Disbursed model.
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
     * Finds the Disbursed model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Disbursed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Disbursed
    {
        if (($model = Disbursed::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetPeriods()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = ProjectPeriod::find()
                ->where(['project_period.project_id' => $id])
                ->asArray()
                ->all();

            $selected = '';

            if ($id != null && count($list) > 0) {

                $out = array_map(
                    function ($list) {
                        return [
                            'id' => $list['id'],
                            'name' => $list['name']
                        ];
                    },
                    $list
                );

                return ['output' => $out, 'selected' => $selected];
            }
        }
        return ['output' => '', 'selected' => ''];
    }
}
