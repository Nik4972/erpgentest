<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use common\widgets\LeveledGridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use backend\models\Table;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AddressTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Macroregions GEO';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = join('', array_slice(explode('\\', get_class($searchModel)), -1)); // get class name without namespace
$this->params['model'] = join('', array_slice(explode('\\', get_parent_class($searchModel)), -1)); // get class name without namespace

?>
<div class="address-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php Pjax::begin(); ?>    
    <p>
        <?= Html::a('Create Macroregion GEO', ['create', $this->params['model'].'[group_id]' => $searchModel->is_group ? $searchModel->group_id : null], 
            ['class' => 'btn btn-success', 'data-toggle' => 'xmodal', 'data-target' => '#myModal']) ?>
    </p>
    <?php 
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < strlen($str); $i ++) {
        echo Html::a($str[$i], Url::current(['search' => ($searchModel->search == $str[$i] ? '' : $str[$i])]), ['class' => 'btn '.($searchModel->search == $str[$i]? 'btn-primary' : 'btn-success')]);
        }
    ?>
    <?php  // echo $this->render('_search', ['model' => $searchModel]); ?>
<?= $a = LeveledGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id'],
            ['attribute' => 'title', 'format' => 'html', 'value' => function ($data) {
                return $data->is_group ? '<a href="'.Url::current([$this->params['searchModel'] => ['group_id' => $data->id, 'is_group' => 1]]).'">'.$data->title.'</a>' : $data->title;
            }],
            ['attribute' => 'status', 'filter' => [1=>'actual','archive','deleted',4=>'all'], 'value' => function ($data) {return Table::$statusTitles[$data->status];}],
            ['attribute' => 'is_group', 'label' => 'Group', 'filter' => [1=>'grouped',0=>'flat'], 'format' => 'html', 'value' => function ($data) {
                return $data->group ? '<a href="'.Url::current([$this->params['searchModel'] => ['group_id' => $data->group_id, 'is_group' => 1]]).'">'.$data->group->title.'</a>' : '';
            }],
            ['class' => 'common\widgets\LeveledActionColumn', 'filter' => Html::a('Reset', ['index']), 'visibleButtons'=>['view' => false]],
        ],
    ]); 
    ?>
<?php Pjax::end(); ?></div>
