<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\models\VoucherFormatLogo as CheckLogo;
use Yii;
use app\modules\movement\models\CheckFormat;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use function Faker\Provider\pt_BR\check_digit;

/**
 * CheckFormatController implements the CRUD actions for CheckFormat model.
 */
class CheckFormatController extends BaseController
{

    /**
     * Lists all CheckFormat models.
     * @return string
     */
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CheckFormat::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CheckFormat model.
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
     * Creates a new CheckFormat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new CheckFormat();
        $CheckLogo = new CheckLogo;

        if ($model->loadAll(Yii::$app->request->post())) {
            $CheckLogo->logoFile = UploadedFile::getInstance($CheckLogo, 'logoFile');

            if ($CheckLogo->upload())
                $model->logo_path = $CheckLogo->path;

            $model->save(false);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'checkLogo' => $CheckLogo
            ]);
        }
    }

    /**
     * Updates an existing CheckFormat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $CheckLogo = new CheckLogo;

        if ($model->loadAll(Yii::$app->request->post())) {
            $CheckLogo->logoFile = UploadedFile::getInstance($CheckLogo, 'logoFile');

            if ($CheckLogo->upload())
                $model->logo_path = $CheckLogo->path;

            $model->save(false);
            Yii::$app->session->setFlash('success', 'Se actulizo correctamente el formato de solicitud de cheques');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'checkLogo' => $CheckLogo
            ]);
        }
    }

    /**
     * Deletes an existing CheckFormat model.
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
     * Finds the CheckFormat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CheckFormat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): CheckFormat
    {
        if (($model = CheckFormat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
