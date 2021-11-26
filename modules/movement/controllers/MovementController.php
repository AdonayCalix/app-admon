<?php

namespace app\modules\movement\controllers;

use app\modules\movement\components\CheckIfDateIsOutPeriod;
use app\modules\project\components\HierachyActivityList;
use app\modules\project\models\ProjectPeriod;
use app\modules\qb\components\HierachyChartAccountList;
use app\modules\qb\components\HierarchyClassList;
use Yii;
use app\modules\movement\models\Movement;
use app\modules\movement\models\MovementSearch;
use app\controllers\base\BaseController;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * MovementController implements the CRUD actions for Movement model.
 */
class MovementController extends BaseController
{


    /**
     * Lists all Movement models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new MovementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Movement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerMovementDetail = new \yii\data\ArrayDataProvider([
            'allModels' => $model->movementDetails,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerMovementDetail' => $providerMovementDetail,
        ]);
    }

    /**
     * Creates a new Movement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return Response|string
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Movement();

        if ($model->load(Yii::$app->request->post()) && $model->store($_POST['Movement'])) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Movement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
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
     * Deletes an existing Movement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the Movement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Movement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Movement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetAllClasses()
    {
        return json_encode((new HierarchyClassList())->setMainClasses()->setOptions()->get());
    }

    public function actionGetAllAccounts()
    {
        return json_encode((new HierachyChartAccountList())->setmainAccount()->setOptions()->get());
    }

    public function actionGetAllActivities($project_id)
    {
        return json_encode((new HierachyActivityList($project_id))->setBudgets()->setOptions()->get());
    }

    public function actionValidateDate($date, $projectId)
    {
        $result = [
            'isValid' => (new CheckIfDateIsOutPeriod($date, $projectId))
                ->setPeriodSuchCurrentDate()
                ->setPeriodSuchDate()
                ->result()
        ];

        return json_encode($result);
    }
}
