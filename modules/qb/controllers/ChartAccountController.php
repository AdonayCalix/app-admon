<?php

namespace app\modules\qb\controllers;

use app\modules\qb\components\LoadAccounts;
use app\modules\qb\models\ImportForm;
use Yii;
use app\modules\qb\models\ChartAccount;
use app\modules\qb\models\ChartAccountSearch;
use app\controllers\base\BaseController;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ChartAccountController implements the CRUD actions for ChartAccount model.
 */
class ChartAccountController extends BaseController
{

    /**
     * Lists all ChartAccount models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ChartAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChartAccount model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ChartAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new ChartAccount();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ChartAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * Deletes an existing ChartAccount model.
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

    public function actionImport(): string
    {
        $model = new ImportForm;

        if (Yii::$app->request->post()) {

            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');

            if ($model->upload()) {
                (new LoadAccounts($model->fileName))
                    ->loadExcelFile()
                    ->store();
            }
        }

        return $this->render('_import', ['model' => $model]);
    }
    
    /**
     * Finds the ChartAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChartAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): ChartAccount
    {
        if (($model = ChartAccount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
