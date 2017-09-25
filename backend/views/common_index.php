<?php
if (!$searchModel->status)
    $searchModel->status = [1];
use kartik\checkbox\CheckboxX;

use yii\helpers\Html;
use yii\grid\GridView;
//use common\widgets\LeveledGridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AddressTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use backend\ErpEnums;

$this->title = $searchModel::tableNotion();
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = join('', array_slice(explode('\\', get_class($searchModel)), -1)); // get class name without namespace
$this->params['model'] = join('', array_slice(explode('\\', get_parent_class($searchModel)), -1)); // get class name without namespace

yii\jui\JuiAsset::register($this); // add jquery.ui scripts to this page
kartik\checkbox\CheckboxXAsset::register($this); // add CheckboxX scripts to this page

$show_tree = (!isset($_GET['show_tree']) || $_GET['show_tree']) && $searchModel::withGroups;
$show_alphabet = !isset($_GET['show_alphabet']) || $_GET['show_alphabet'];

?>
<div class="address-type-index">

    <h1><?= Html::encode($this->title) ?></h1>



<style>
    table#tree {width: 30%; float: right;}
    div#tree2 {width: 30%; float: left; padding-right: 15px;}
    div.with_tree {width: 70%; float: right}
    div#alphabetFilter {margin-left: 0px}
    tr.selected td {background-color: green}
    .row-icon-bg {color: black}
    .row-icon-2, .row-icon-3 {color: red; zoom: 90%}
    .row-icon {color: #63E7E0; }
    .row-icon-group {color: #FFFFBF}
    .fa-stack {height: 1em;line-height: 1em;}
    .checkbox, .select-on-check-all {zoom: 120%}
    .cbx {background-color: #DEDEDE; border-color: #676767}
    .table-striped > tbody > tr:nth-of-type(odd) {background-color: #EAE9ED;}
    .table-striped > tbody > tr:nth-of-type(even) {background-color: #E0DEE7;}
    .table-striped > thead > tr {background-color: #B3AFBC;}
    .table-bordered, .table-bordered td, .table-bordered th {border: 1px solid #5F5F5F !important;}
    .table-striped > thead  a {color: black;}
    .tree-header {display: none}
    div#alphabetFilter {margin-top: 10px; margin-bottom: 10px}
</style>


<?php Pjax::begin(); ?>

<!-- toolbar -->


<div class="btn-toolbar row" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group" role="group" aria-label="First group">
        <!--button type="button" class="btn btn-default" xdata-toggle="tooltip" title="Create New Element">1</button-->
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Create New Element"><span class="glyphicon glyphicon-plus"></span></a>
        <a href="" type="button" class="btn btn-default<?= $searchModel::withGroups ? '' : ' disabled' ?>" xdata-toggle="tooltip" title="Create New Group"><span class="glyphicon glyphicon-folder-open"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Edit Record"><span class="glyphicon glyphicon-pencil"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="View Record"><span class="glyphicon glyphicon-info-sign"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Copy Record"><span class="glyphicon glyphicon-file"></span></a>
        <a href="<?=Url::to(['set-status'])?>" onclick="return listForm.submitForm(this)" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Change Record Status"><span class="glyphicon glyphicon-tags"></span></a>
        <a href="<?=Url::to(['delete'])?>" onclick="return listForm.submitForm(this)" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Delete/Undelete Record"><span class="glyphicon glyphicon-trash"></span></a>
        <a href="<?=Url::to(['set-group'])?>" onclick="return listForm.submitForm(this)" xhref="" type="button" class="btn btn-default<?= $searchModel::withGroups ? '' : ' disabled' ?>" xdata-toggle="tooltip" title="Move To Group"><span class="glyphicon glyphicon-log-in"></span></a>
    </div>
    <div class="btn-group" role="group" aria-label="Second group">
        <a href="<?=Url::current(['show_tree' => !$show_tree])?>" type="button" class="btn btn-default<?= $searchModel::withGroups ? '' : ' disabled' ?>" xdata-toggle="tooltip" title="Show/Hide Tree"><span class="glyphicon glyphicon-indent-right"></span></a>
        <a href="<?=Url::current([$this->params['searchModel'] => ['group' => !$searchModel->group, 'parent' => $searchModel->group ? null : $searchModel->parent]])?>" type="button" class="btn btn-default<?= $searchModel::withGroups ? '' : ' disabled' ?>" xdata-toggle="tooltip" title="View With/Without Hierarchy"><span class="glyphicon glyphicon-tasks"></span></a>
        <a xhref="" type="button" class="btn btn-default" zxdata-toggle="tooltip" title="Configure Columns" data-toggle="modal" data-target="#modalColumns"><span class="glyphicon glyphicon-list-alt"></span></a>
    </div>

<?php $form = yii\widgets\ActiveForm::begin(['method' => 'get', 'action' => Url::current([$this->params['searchModel'] => ['status' => null]])]); ?>
    <div class="btn-group" role="group" aria-label="Third group">
		<button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle " type="button" title="Filter by Status">
		    <span class="glyphicon glyphicon-screenshot"></span>
		    <span class="caret"></span>
		</button>
        <ul role="menu" class="dropdown-menu">
            <?php foreach (ErpEnums::$RecordStatuses as $key => $notion) { ?>
            <li><a href="#">
            <input type="checkbox" name="<?=$this->params['searchModel']?>[status][]" value="<?= $key ?>"<?=in_array($key, $searchModel->status) ? ' checked="checked"' : ''?>><span class="lbl"> <?= $notion ?></span>
            </a></li>
            <?php } ?>
            <li><?= Html::submitButton('Apply', ['class' => 'btn btn-primary']) ?></li>
        </ul>


        <a id="xbtn_alphabetFilter" href="<?=Url::current(['show_alphabet' => !$show_alphabet])?>" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Show/Hide Filter by First Character"><span class="glyphicon glyphicon-font"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Filters Templates"><span class="glyphicon glyphicon-filter"></span></a>
    </div>
<?php yii\widgets\ActiveForm::end(); ?>

    <div class="btn-group" role="group" aria-label="Fourth group">
        <!--a href="" type="button" class="btn btn-default" data-toggle="tooltip" title="Export to Excel"><span class="glyphicon glyphicon-floppy-save"></span></a>
        <a href="" type="button" class="btn btn-default" data-toggle="tooltip" title="Export to PDF"><span class="glyphicon glyphicon-leaf"></span></a-->

<?php
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        'id',
        'notion',
        /*[
            'attribute'=>'author_id',
            'label'=>'Author',
            'vAlign'=>'middle',
            'width'=>'190px',
            'value'=>function ($model, $key, $index, $widget) { 
                return Html::a($model->author->name, '#', []);
            },
            'format'=>'raw'
        ],
        'color',
        'publish_date',
        'status',
        ['attribute'=>'buy_amount','format'=>['decimal',2], 'hAlign'=>'right', 'width'=>'110px'],
        ['attribute'=>'sell_amount','format'=>['decimal',2], 'hAlign'=>'right', 'width'=>'110px'],
        ['class' => 'kartik\grid\ActionColumn', 'urlCreator'=>function(){return '#';}]*/
    ];

    use kartik\export\ExportMenu;
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        //'columns' => $gridColumns,
        'showColumnSelector' => false,
        'fontAwesome' => true,
        'asDropdown' => true
    ]);
?>

        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Send Email"><span class="glyphicon glyphicon-gift"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Print"><span class="glyphicon glyphicon-print"></span></a>
    </div>
    
    
</div>


<!-- end toolbar -->

<?php
if ($show_alphabet) { // "search by alphabet" panel
?>

<div class="row " id="alphabetFilter">
    <?php 
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = $searchModel->getFilterAlphabet();
    for ($i = 0; $i < count($str); $i ++) {
        echo Html::a($str[$i], Url::current(['search' => ($searchModel->search == $str[$i] ? '' : $str[$i])]), 
            ['class' => 'btn '.($searchModel->search == $str[$i]? 'btn-primary' : 'btn-success')]);
        }
    ?>
</div>

<?php
}  // end "search by alphabet" panel
?>

<!-- list of table records -->

<?php  
    $statusIcon = [2 => 'question', 'remove'];

    $min_width = 1;
    $columnsAll = $searchModel->getColumns();
    $columns = [ // predefined columns write here
        /* // testing related model
        ['attribute' => 'parent', 'format' => 'html', 'value' => function ($data) {
            return $data->address ? $data->address->notion : '';
        }],*/

        ['class' => 'yii\grid\CheckboxColumn', 'name' => 'ids[]', 'options' => ['width'=> $min_width.'%'], 'cssClass' => ['checkbox', 'ids'], 
            'header' => '<input type="checkbox" id="ids_x" value="0" data-toggle="checkbox-x" data-size="xs">'
        ], 
        ['attribute' => 'id', 'filter' => false, 'enableSorting'=>false, 'format' => 'raw', 'options' => ['width'=> $min_width.'%'], 'label' => false,
        'value' => function($data) use($statusIcon) {
            return '<span class="fa-stack"><i class="fa fa-folder fa-stack-1x row-icon'
                .($data['group'] ? '-group' : '').'"></i><i class="fa fa-folder-o fa-stack-1x row-icon-bg"></i>'
                .($data['status'] > 1 ? '<i class="fa fa-'.$statusIcon[$data['status']].' fa-stack-1x row-icon-'.$data['status'].'"></i>' : '')
                .'</span>'
                .($data['predefined'] ? ' <i class="fa fa-lock"></i>' : '');
        }],
    ]; // actual columns will be displayed

    foreach ($columnsConfig as $col_name => $col_visible) { // traverse over columns in saved order
        if (!$col_visible)
            continue;
        
        $colDef = [
            'attribute' => $col_name, 
            // filter depends on column type (and name for special columns like the "notion")
            'filter' => \backend\ErpForm::getColumnFilter($col_name, $columnsAll[$col_name], $searchModel) 
        ];

        $val = \backend\ErpForm::getColumnValue($col_name, $columnsAll[$col_name], $this);
        if ($val) {
            $colDef['value'] = $val;
            $colDef['format'] = 'raw';
        }
        if ($columnsAll[$col_name]['type'] == 'enum') {
            //echo "\n\n", '<pre>$colDef = ';print_r($colDef);die;
        }
            
        $columns[] = $colDef;
    }
    
    // setting same width for columns to keep the html table from autoresizing of columns
    $min_width = floor((100 - $min_width*2) / (count($columns) - 2));
    for($i = 2; $i < count($columns); $i ++) {
        $columns[$i]['options']['width'] = $min_width.'%';
    }
?>


<div id="table" class="<?= $show_tree ? 'with_tree' : '' ?>">
<?= $a = GridView::widget([
        'tableOptions' => ['class' => 'table table-striped table-bordered '],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{summary}\n{pager}", 
        'columns' => $columns
        /*
        'columns' => [
            
            //['attribute' => 'id', 'filter' => '<a href="/backend/web/index.php?r=address-type" title="Level Up" aria-label="Level Up" data-pjax="0"><span class="glyphicon glyphicon-open"></span> Up</a>'],
            ['attribute' => 'id'],
            ['attribute' => 'notion', 'format' => 'html', 'value' => function ($data) {
                return $data->group ? '<a href="'.Url::current([$this->params['searchModel'] => ['parent' => $data->id, 'group' => 1]]).'">'.$data->notion.'</a>' : $data->notion;
            }],
            ['attribute' => 'type', 'filter' => ['registry'=>'registry', 'logistic'=>'logistic', 'other'=>'other'], 'value' => function ($data) {return $data->group ? '' : $data->type;}],
            ['attribute' => 'status', 'filter' => [1=>'actual','archive','deleted',4=>'all'], 'value' => function ($data) {return backend\ErpTable::$statusTitles[$data->status];}],
            ['attribute' => 'group', 'label' => 'Group', 'filter' => [1=>'grouped',0=>'flat'], 'format' => 'html', 'value' => function ($data) {
                return $data->group ? '<a href="'.Url::current([$this->params['searchModel'] => ['parent' => $data->parent, 'group' => 1]]).'">'.$data->group->notion.'</a>' : '';
            }],
            ['class' => 'common\widgets\LeveledActionColumn', 
                'filter' => '<a id="btn_filterSave" href="#" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk"></span></a> <a href="'.Url::to(['index']).'" class="btn btn-default"><span class="glyphicon glyphicon-remove-circle"></span></a>', 'visibleButtons'=>['view' => false]],
        ],
        */
    ]); 
    ?>
</div>

<?php $form = yii\widgets\ActiveForm::begin(['method' => 'post', 'id'=>'formList', 'action' => Url::current()]); ?>
<?php yii\widgets\ActiveForm::end(); ?>

<!-- end list of table records -->


<!-- tree window -->

<?php

use execut\widget\TreeView;
use yii\web\JsExpression;

if ($show_tree) {
?>

<div id="tree2">

<?php

    $strIcon = '<span class="fa-stack"><i class="fa fa-folder fa-stack-1x row-icon-group"></i><i class="fa fa-folder-o fa-stack-1x row-icon-bg"></i></span>';

    $treeParams = [ // instructions for node of https://github.com/jonmiles/bootstrap-treeview will be passed over TreeView::widget
        ['function' => function ($row, $param) {
                if ($row['id'] == $param['id'])
                    return ['state' => ['selected' => true]];
                
                return [];
            }, 'id' => $searchModel->parent],
        ['column' => 'notion', 'attr' => 'text', 'var' => '{notion}', 'template' => $strIcon.' {notion}'],
        ['column' => 'id', 'attr' => 'href', 'var' => '%7Bid%7D', 'template' => Url::current([$this->params['searchModel'] => ['parent' => '{id}', 'group' => 1]])],
    ];

    $data = [['text' => $strIcon.' Root Group', 'id' => 0, 'href' => Url::current([$this->params['searchModel'] => ['parent' => null, 'group' => 1]]),
        'nodes' => $searchModel->getGroupsTree($treeParams), 'color' => 'blue']];
        
    $onSelect = new JsExpression('
    function (undefined, item) {
        listForm.selectGroup(item.id);
        console.log(item);
    }');

    $treeTemplate = '<div class="tree-view-wrapper">
        <div class="row tree-header">
            <div class="col-sm-6">
                <div class="tree-heading-container">{header}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                {tree}
            </div>
        </div>
    </div>';
    $groupsContent = TreeView::widget([
        'data' => $data,
        'template' => $treeTemplate,
        //'size' => TreeView::SIZE_SMALL,
        'header' => false, //'Groups',
        'clientOptions' => [
            'onNodeSelected' => $onSelect,
            'onNodeUnselected' => $onSelect,
            'enableLinks' => true,
            'selectedBackColor' => 'rgb(40, 153, 57)',
            'borderColor' => '#fff',
            'levels' => 3,
            'color' => '#428bca',
            'expandIcon' => 'glyphicon glyphicon-chevron-right',
            'collapseIcon' => 'glyphicon glyphicon-chevron-down',
            'nodeIcon' => 'glyphicon glyphicon-bookmark',
        ],
    ]);
    
    
    echo $groupsContent;
?>

</div>

<?php
}
?>


<!--div id="treeview10" class=""></div>

<script>
        var defaultData = [
          {
            text: 'Parent 1',
            href: '#parent1',
            tags: ['4'],
            nodes: [
              {
                text: 'Child 1',
                href: '#child1',
                tags: ['2'],
                nodes: [
                  {
                    text: 'Grandchild 1',
                    href: '#grandchild1',
                    tags: ['0']
                  },
                  {
                    text: 'Grandchild 2',
                    href: '#grandchild2',
                    tags: ['0']
                  }
                ]
              },
              {
                text: 'Child 2',
                href: '#child2',
                tags: ['0']
              }
            ]
          },
          {
            text: 'Parent 2',
            href: '#parent2',
            tags: ['0']
          },
          {
            text: 'Parent 3',
            href: '#parent3',
             tags: ['0']
          },
          {
            text: 'Parent 4',
            href: '#parent4',
            tags: ['0']
          },
          {
            text: 'Parent 5',
            href: '#parent5'  ,
            tags: ['0']
          }
        ];


    window.onload = function () {
    alert('aa');
$('#treeview10').treeview({
          color: "#428bca",
          enableLinks: true,
          data: defaultData
        });
    }
</script-->

<!-- end tree window -->

<script>
    if (typeof(listForm) == 'object') {
        listForm.init();
    }
</script>

<?php Pjax::end(); ?>


<!-- columns order and visibility management -->

<div class="modal fade" id="modalColumns" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <?php $form = yii\widgets\ActiveForm::begin(['action' => Url::to(['columns'])]); ?>

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reorder columns by drag-n-drop</h4>
      </div>
      <div class="modal-body">

        <div id="tabs">
        
            <table class="table table-striped">
                <tbody>
                    <tr><td><b>Columns</b></td></tr>
        <?php
            $columnsAll = $searchModel->getColumns();
            
            foreach ($columnsConfig as $col_name => $col_visible) {
                echo '<tr><td><input type="hidden" name="columns[',$col_name,']" value="0"/>';
                if (isset($columnsAll[$col_name]['always_visible']) && $columnsAll[$col_name]['always_visible'])
                    echo '<input type="checkbox" checked="checked" disabled="disabled"/> ',$columnsAll[$col_name]['notion'],'</td></tr>';
                else
                    echo '<input type="checkbox" name="columns[',$col_name,']" value="',$col_name,'"',
                        ($col_visible ? ' checked="checked"' : ''),'/> ',$columnsAll[$col_name]['notion'],'</td></tr>';
                echo '</td></tr>';
            }
        ?>
                </tbody>
            </table>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?= Html::submitButton('Save Columns', ['class' => 'btn btn-primary']) ?>
      </div>
      
      <?php yii\widgets\ActiveForm::end(); ?>
      
    </div>
  </div>
</div>


<!-- end columns order and visibility management -->

