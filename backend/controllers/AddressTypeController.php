<?php

namespace backend\controllers;

use Yii;
use backend\models\AddressType;
use backend\models\AddressTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\ErpEnums;
use backend\ErpForm;

/**
 * AddressTypeController implements the CRUD actions for AddressType model.
 */
class AddressTypeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AddressType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AddressTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columnsConfig' => \backend\ErpForm::getColumns($searchModel)
        ]);
    }

    /**
     * Manage an order and a visibility of table columns
     * @return mixed
     */
    public function actionColumns() // TODO: move code to model
    {
        $model = new AddressType();
        ErpForm::saveColumns($model);
        return $this->redirect(['index']);
    }

    /**
     * Displays a single AddressType model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AddressType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AddressType();
        
        //$this->layout = false; // fix

        $result = $model->load(array_merge(Yii::$app->request->get(), Yii::$app->request->post()));
        if ($model->parent == 0) {
            $model->parent = null;
        }
        if ($result && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AddressType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $result = $model->load(Yii::$app->request->post());
        if ($model->parent == 0) {
            $model->parent = null;
        }
        if ($result && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AddressType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AddressType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AddressType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AddressType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
