<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\models\VoucherFormatForm;
use Yii;
use app\modules\movement\models\VoucherFormat;
use app\modules\movement\models\VoucherFormatSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * VoucherFormatController implements the CRUD actions for VoucherFormat model.
 */
class VoucherFormatController extends BaseController
{

    /**
     * Lists all VoucherFormat models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new VoucherFormatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VoucherFormat model.
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
     * Creates a new VoucherFormat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new VoucherFormat();
        $voucherFormatForm = new VoucherFormatForm;

        if ($model->load(Yii::$app->request->post())) {

            $voucherFormatForm->excelFile = UploadedFile::getInstance($voucherFormatForm, 'excelFile');

            if ($voucherFormatForm->upload()) {
                $model->original_name = $voucherFormatForm->originalName;
                $model->path = $voucherFormatForm->path;
            }

            $model->save(false);

            Yii::$app->session->setFlash('success', 'Se creo correctamente el formato del voucher');

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'voucherFormatForm' => $voucherFormatForm
            ]);
        }
    }

    /**
     * Updates an existing VoucherFormat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $voucherFormatForm = new VoucherFormatForm;

        if ($model->load(Yii::$app->request->post())) {
            $voucherFormatForm->excelFile = UploadedFile::getInstance($voucherFormatForm, 'excelFile');

            if ($voucherFormatForm->upload()) {
                $model->original_name = $voucherFormatForm->originalName;
                $model->path = $voucherFormatForm->path;
            }

            $model->save(false);
            Yii::$app->session->setFlash('success', 'Se actualizo correctamente el formato de voucher');

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'voucherFormatForm' => $voucherFormatForm
            ]);
        }
    }

    /**
     * Deletes an existing VoucherFormat model.
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
     * Finds the VoucherFormat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VoucherFormat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): VoucherFormat
    {
        if (($model = VoucherFormat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
