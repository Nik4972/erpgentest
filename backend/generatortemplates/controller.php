<?php

echo '<', '?php';
$className = ucfirst($name_tables['name']);
$moduleName = $name_tables['module'] ? $name_tables['module'] : 'core';
$searchModelClass = $className."Search";
?>

namespace backend\modules\<?= $moduleName ?>\controllers;

use backend\modules\<?= $moduleName ?>\models\<?= $className ?>;
use backend\modules\<?= $moduleName ?>\models\<?= $searchModelClass  ?>;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \backend\ErpEnums;
use \backend\ErpForm;

/**
 * <?= $className ?>Controller implements the CRUD actions for <?= $className ?> model.
 */
class <?= $className ?>Controller extends Controller
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
     * Lists all <?= $className ?> models.
     * @return mixed
     */
     public function getViewPath()
{
    return Yii::getAlias('@backend/modules/core/views');
}

    public function actionIndex()
    {

        $searchModel = new <?= $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@app/views/common_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columnsConfig' => \backend\ErpForm::getColumns($searchModel)
        ]);
    }

    /**
     * Displays a single <?= $className ?> model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new <?= $className ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id=0)
    { //$id=0 - элемент , иначе группа
        $model = new <?= $className ?>();

        if ($model->load(Yii::$app->request->post())){
            if ($model->save()) {
                return $this->redirect(['view', ['model' => $model]]);
            } 
            else{
                 Yii::$app->session->setFlash('error', Yii::t('app', 'ERROR_UPDATE_MODEL'));
                 return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else {
            return $this->render('create', [
                'model' => $model,'group' => $id
            ]);
        }
    }
    /**
     * Updates an existing <?= $className ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            if ($model->save()) {
                return $this->redirect(['view', $id]);
            }
            else{
                 Yii::$app->session->setFlash('error', Yii::t('app', 'ERROR_UPDATE_MODEL'));
                 return $this->render('update', [
                'model' => $model,
            ]);
            }
        }
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing <?= $className ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id=0)
    {//$ids - массив выбранных id 
    if ($id==0){
        $ids=\Yii::$app->request->post('ids');
    }
    else{
        $ids = [$id];
    }
    
        foreach ($ids as $id){
            $model=$this->findModel($id);
            if ($model->status==<?= $className ?>::STATUS_DELETED){
                $model->status==<?= $className ?>::STATUS_NONACTUAL;
            }
            elseif($model->status==<?= $className ?>::STATUS_NONACTUAL){
                $model->status==<?= $className ?>::STATUS_DELETED;
            }
            if (!$model->save()){
                Yii::$app->session->setFlash('error', Yii::t('app', 'ERROR_UPDATE_STATUS'));
                return $this->render('update', [
                'model' => $model,
            ]);
            }
        }
        
        return $this->render('index', []);     
    }

    /**
     * Finds the <?= $className ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return <?=$className ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = <?= $className ?>::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionDuplicate($id)
    {
        $original_model=$this->findModel($id);
        
        $model = new <?= $className ?>();
        $model->attributes = $original_model->attributes;
            
        return $this->render('create', [
                'model' => $model,
            ]);       
    }
    public function actionSetStatus($id=0)
    { //$ids - массив выбранных id 
        if ($id==0){
            $ids=\Yii::$app->request->post('ids');
        }
        else{
            $ids = [$id];
        }
        foreach ($ids as $id){
            $model=$this->findModel($id);
            if ($model->status==<?= $className ?>::STATUS_ACTUAL){
                $model->status==<?= $className ?>::STATUS_NONACTUAL;
            }
            elseif($model->status==<?= $className ?>::STATUS_NONACTUAL){
                $model->status==<?= $className ?>::STATUS_ACTUAL;
            }
            if (!$model->save()){
                Yii::$app->session->setFlash('error', Yii::t('app', 'ERROR_UPDATE_STATUS'));
                return $this->render('update', [
                'model' => $model,
            ]);
            }
        }
        
        return $this->render('index', []);    
    }
    public function actionSetGroup(){
        //$ids - массив выбранных id 
        if (self::withGroups){
            $ids=\Yii::$app->request->post('ids');
            $parent_id = \Yii::$app->request->post('parent_id');
            <?= $className ?>::updateAll(['parent' => $parent_id], ['in', 'id', $ids]);
        }
        return $this->render('index', []);    
    }
    public function actionPrintModel($id=0){
        if ($id){
            $model=$this->findModel($id);
        }
        else{
            $searchModel = new <?= $searchModelClass ?>();
            $model = $searchModel->search(Yii::$app->request->queryParams);
        }
        $template=\Yii::$app->request->get('template');
        return $this->render($template, [
                'model' => $model,
            ]);
    }
    public function GetPrintTemplate(){
       return['Форма1' => 'template1', 'Форма2' => 'template2'];        
    }
    
    /**
     * Manage an order and a visibility of table columns
     * @return mixed
     */
    public function actionColumns()
    {
        $model = new <?= $className ?>();
        ErpForm::saveColumns($model);
        return $this->redirect(['index']);
    }

    
}
