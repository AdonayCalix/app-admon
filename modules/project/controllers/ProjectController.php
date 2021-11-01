<?php

namespace app\modules\project\controllers;

use app\modules\project\components\FormatDate;
use Yii;
use app\modules\project\models\Project;
use app\modules\project\models\ProjectSearch;
use app\controllers\base\BaseController;
use yii\data\ArrayDataProvider;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends BaseController
{


    /**
     * Lists all Project models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderIsAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $model = $this->findModel($id);
        $providerProjectBudget = new ArrayDataProvider([
            'allModels' => $model->projectBudgets,
        ]);
        $providerProjectPeriod = new ArrayDataProvider([
            'allModels' => $model->projectPeriods,
        ]);
        return $this->renderIsAjax('view', [
            'model' => $this->findModel($id),
            'providerProjectBudget' => $providerProjectBudget,
            'providerProjectPeriod' => $providerProjectPeriod,
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderIsAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException|Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadAll(Yii::$app->request->post()) && $model->validate() && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws Exception|NotFoundHttpException
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Project
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Action to load a tabular form grid
     * for ProjectBudget
     * @return mixed
     * @throws NotFoundHttpException
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     */
    public function actionAddProjectBudget()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ProjectBudget');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formProjectBudget', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for ProjectPeriod
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddProjectPeriod()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ProjectPeriod');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formProjectPeriod', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
