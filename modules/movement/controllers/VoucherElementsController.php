<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\models\VoucherFormatLogo;
use Yii;
use app\modules\movement\models\VoucherElements;
use app\modules\movement\models\VoucherElementsSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * VoucherElementsController implements the CRUD actions for VoucherElements model.
 */
class VoucherElementsController extends BaseController
{
    /**
     * Lists all VoucherElements models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new VoucherElementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VoucherElements model.
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
     * Creates a new VoucherElements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new VoucherElements();
        $voucherFormatLogo = new VoucherFormatLogo;

        if ($model->loadAll(Yii::$app->request->post())) {
            $voucherFormatLogo->excelFile = UploadedFile::getInstance($voucherFormatLogo, 'logoFile');

            if ($voucherFormatLogo->upload())
                $model->logo_path = $voucherFormatLogo->originalName;

            $model->save(false);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VoucherElements model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $voucherFormatLogo = new VoucherFormatLogo;

        if ($model->loadAll(Yii::$app->request->post())) {

            $voucherFormatLogo->excelFile = UploadedFile::getInstance($voucherFormatLogo, 'logoFile');

            if ($voucherFormatLogo->upload())
                $model->logo_path = $voucherFormatLogo->originalName;

            $model->save(false);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VoucherElements model.
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
     * Finds the VoucherElements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VoucherElements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): VoucherElements
    {
        if (($model = VoucherElements::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
