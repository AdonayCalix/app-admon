<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\project\models\Beneficiary;
use Yii;
use app\modules\movement\models\VoluntaryContribution;
use app\models\VoluntaryContributionSearch;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * VoluntaryContributionController implements the CRUD actions for VoluntaryContribution model.
 */
class VoluntaryContributionController extends BaseController
{
    /**
     * Lists all VoluntaryContribution models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new VoluntaryContributionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VoluntaryContribution model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $model = $this->findModel($id);
        $providerVoluntaryContributionDetail = new \yii\data\ArrayDataProvider([
            'allModels' => $model->voluntaryContributionDetails,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerVoluntaryContributionDetail' => $providerVoluntaryContributionDetail,
        ]);
    }

    /**
     * Creates a new VoluntaryContribution model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return Response|string
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new VoluntaryContribution();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VoluntaryContribution model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException|Exception
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
     * Deletes an existing VoluntaryContribution model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the VoluntaryContribution model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VoluntaryContribution the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): VoluntaryContribution
    {
        if (($model = VoluntaryContribution::findOne($id)) !== null) {
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
