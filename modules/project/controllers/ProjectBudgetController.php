<?php

namespace app\modules\project\controllers;

use app\modules\budget\models\BudgetPeriod;
use app\modules\project\models\ProjectPeriod;
use Yii;
use app\modules\project\models\ProjectBudget;
use app\modules\project\models\ProjectBudgetSearch;
use app\controllers\base\BaseController;
use yii\data\ArrayDataProvider;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ProjectBudgetController implements the CRUD actions for ProjectBudget model.
 */
class ProjectBudgetController extends BaseController
{

    /**
     * Lists all ProjectBudget models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ProjectBudgetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderIsAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectBudget model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $model = $this->findModel($id);
        $providerBudgetCategory = new ArrayDataProvider([
            'allModels' => $model->budgetCategories,
        ]);
        return $this->renderIsAjax('view', [
            'model' => $this->findModel($id),
            'providerBudgetCategory' => $providerBudgetCategory,
        ]);
    }

    /**
     * Creates a new ProjectBudget model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new ProjectBudget();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            Yii::$app->session->setFlash('success', 'Se creo correctamente el Presupuesto/POA');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderIsAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectBudget model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadAll(Yii::$app->request->post()) && $model->validate() && $model->saveAll()) {
            Yii::$app->session->setFlash('success', 'Se actualizo correctamente el Presupuesto/POA');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderIsAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectBudget model.
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
     * Finds the ProjectBudget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectBudget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): ProjectBudget
    {
        if (($model = ProjectBudget::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAssignBudget($id): string
    {

        if (Yii::$app->request->post()) {
            BudgetPeriod::store($_POST['BudgetPeriod'] ?? []);
        }
        return $this->render('_assign', ['budget_id' => $id]);
    }

    public function actionGetAll($id, $period_id)
    {
        return json_encode(ProjectBudget::getCategories($id, $period_id));
    }

    public function actionGetPeriodsByProject($id)
    {
        return json_encode(ProjectPeriod::getPeriods($id));
    }

    /**
     * Action to load a tabular form grid
     * for BudgetCategory
     * @return string
     * @throws NotFoundHttpException
     *
     */
    public function actionAddBudgetCategory(): string
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('BudgetCategory');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formBudgetCategory', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
