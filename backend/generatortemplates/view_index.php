<?php

echo '<', '?php';
$className = ucfirst($name_tables['name']);
$moduleName = $name_tables['module'] ? $name_tables['module'] : 'core';
$searchModelClass = $className."Search";
?>

use yii\helpers\Html;
use yii\grid\GridView;
//use common\widgets\LeveledGridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AddressTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use \backend\ErpEnums;

//$this->title = Yii::t('mozgo', 'desktop_head'); //'Address Types';
$this->title = '<?= $name_tables['name'] ?>';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = join('', array_slice(explode('\\', get_class($searchModel)), -1)); // get class name without namespace
$this->params['model'] = join('', array_slice(explode('\\', get_parent_class($searchModel)), -1)); // get class name without namespace

yii\jui\JuiAsset::register($this); // add jquery.ui scripts to this page

$show_tree = !isset($_GET['show_tree']) || $_GET['show_tree'];
$show_alphabet = !isset($_GET['show_alphabet']) || $_GET['show_alphabet'];

echo '?', '>';
<div class="address-type-index">

    <h1>echo '<', '?'; Html::encode($this->title) echo '?', '>';</h1>



<style>
    table#tree {width: 30%; float: right}
    div#tree2 {width: 30%; float: left}
    div.with_tree {width: 70%; float: right}
    div#alphabetFilter {margin-left: 0px}
    tr.selected td {background-color: green}
    .row-icon-bg {color: black}
    .row-icon-2, .row-icon-3 {color: red; zoom: 90%}
    .row-icon {color: #63E7E0; }
    .row-icon-group {color: #FFFFBF}
    .fa-stack {height: 1em;line-height: 1em;}
    .checkbox, .select-on-check-all {zoom: 120%}
</style>


    <!--p>
        echo '<', '?'; Html::a('Create Address Type', ['create', $this->params['model'].'[type]' => $searchModel->type, 
            $this->params['model'].'[parent]' => $searchModel->group ? $searchModel->parent : null], ['class' => 'btn btn-success', 'data-toggle' => 'xmodal', 'data-target' => '#myModal']) echo '?', '>';
    </p-->

echo '<', '?php'; Pjax::begin(); echo '?', '>';

<!-- toolbar -->


<div class="btn-toolbar row" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group" role="group" aria-label="First group">
        <!--button type="button" class="btn btn-default" xdata-toggle="tooltip" title="Create New Element">1</button-->
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Create New Element"><span class="glyphicon glyphicon-plus"></span></a>
        <a href="" type="button" class="btn btn-defaultecho '<', '?'; $searchModel::withGroups ? '' : ' disabled' echo '?', '>';" xdata-toggle="tooltip" title="Create New Group"><span class="glyphicon glyphicon-folder-open"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Edit Record"><span class="glyphicon glyphicon-pencil"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="View Record"><span class="glyphicon glyphicon-info-sign"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Copy Record"><span class="glyphicon glyphicon-file"></span></a>
        <a href="echo '<', '?';Url::to(['set-status'])echo '?', '>';" onclick="return listForm.submitForm(this)" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Change Record Status"><span class="glyphicon glyphicon-tags"></span></a>
        <a href="echo '<', '?';Url::to(['delete'])echo '?', '>';" onclick="return listForm.submitForm(this)" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Delete/Undelete Record"><span class="glyphicon glyphicon-trash"></span></a>
        <a href="echo '<', '?';Url::to(['set-group'])echo '?', '>';" onclick="return listForm.submitForm(this)" xhref="" type="button" class="btn btn-defaultecho '<', '?'; $searchModel::withGroups ? '' : ' disabled' echo '?', '>';" xdata-toggle="tooltip" title="Move To Group"><span class="glyphicon glyphicon-log-in"></span></a>
    </div>
    <div class="btn-group" role="group" aria-label="Second group">
        <a href="echo '<', '?';Url::current(['show_tree' => !$show_tree])echo '?', '>';" type="button" class="btn btn-defaultecho '<', '?'; $searchModel::withGroups ? '' : ' disabled' echo '?', '>';" xdata-toggle="tooltip" title="Show/Hide Tree"><span class="glyphicon glyphicon-indent-right"></span></a>
        <a href="echo '<', '?';Url::current([$this->params['searchModel'] => ['group' => !$searchModel->group, 'parent' => $searchModel->group ? null : $searchModel->parent]])echo '?', '>';" type="button" class="btn btn-defaultecho '<', '?'; $searchModel::withGroups ? '' : ' disabled' echo '?', '>';" xdata-toggle="tooltip" title="View With/Without Hierarchy"><span class="glyphicon glyphicon-tasks"></span></a>
        <a xhref="" type="button" class="btn btn-default" zxdata-toggle="tooltip" title="Configure Columns" data-toggle="modal" data-target="#modalColumns"><span class="glyphicon glyphicon-list-alt"></span></a>
    </div>

echo '<', '?php'; $form = yii\widgets\ActiveForm::begin(['method' => 'get', 'action' => Url::current([$this->params['searchModel'] => ['status' => null]])]); echo '?', '>';
    <div class="btn-group" role="group" aria-label="Third group">
		<button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle " type="button" title="Filter by Status">
		    <span class="glyphicon glyphicon-screenshot"></span>
		    <span class="caret"></span>
		</button>
        <ul role="menu" class="dropdown-menu">
            echo '<', '?php'; foreach (ErpEnums::$RecordStatuses as $key => $notion) { echo '?', '>';
            <li><a href="#">
            <input type="checkbox" name="echo '<', '?';$this->params['searchModel']echo '?', '>';[status][]" value="echo '<', '?'; $key echo '?', '>';"echo '<', '?';in_array($key, $searchModel->status) ? ' checked="checked"' : ''echo '?', '>';><span class="lbl"> echo '<', '?'; $notion echo '?', '>';</span>
            </a></li>
            echo '<', '?php'; } echo '?', '>';
            <li>echo '<', '?'; Html::submitButton('Apply', ['class' => 'btn btn-primary']) echo '?', '>';</li>
        </ul>


        <a id="xbtn_alphabetFilter" href="echo '<', '?';Url::current(['show_alphabet' => !$show_alphabet])echo '?', '>';" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Show/Hide Filter by First Character"><span class="glyphicon glyphicon-font"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Filters Templates"><span class="glyphicon glyphicon-filter"></span></a>
    </div>
echo '<', '?php'; yii\widgets\ActiveForm::end(); echo '?', '>';

    <div class="btn-group" role="group" aria-label="Fourth group">
        <!--a href="" type="button" class="btn btn-default" data-toggle="tooltip" title="Export to Excel"><span class="glyphicon glyphicon-floppy-save"></span></a>
        <a href="" type="button" class="btn btn-default" data-toggle="tooltip" title="Export to PDF"><span class="glyphicon glyphicon-leaf"></span></a-->

echo '<', '?php';
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
echo '?', '>';

        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Send Email"><span class="glyphicon glyphicon-gift"></span></a>
        <a href="" type="button" class="btn btn-default" xdata-toggle="tooltip" title="Print"><span class="glyphicon glyphicon-print"></span></a>
    </div>
    
    
</div>


<!-- end toolbar -->

echo '<', '?php';
if ($show_alphabet) { // "search by alphabet" panel
echo '?', '>';

<div class="row" id="alphabetFilter">
    echo '<', '?php'; 
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = $searchModel->getFilterAlphabet();
    for ($i = 0; $i < count($str); $i ++) {
        echo Html::a($str[$i], Url::current(['search' => ($searchModel->search == $str[$i] ? '' : $str[$i])]), 
            ['class' => 'btn '.($searchModel->search == $str[$i]? 'btn-primary' : 'btn-success')]);
        }
    echo '?', '>';
</div>

echo '<', '?php';
}  // end "search by alphabet" panel
echo '?', '>';

<!-- list of table records -->

echo '<', '?php';  
    $statusIcon = [2 => 'question', 'remove'];

    $min_width = 1;
    $columnsAll = $searchModel->getColumns();
    $columns = [ // predefined columns write here
        ['class' => 'yii\grid\CheckboxColumn', 'name' => 'ids[]', 'options' => ['width'=> $min_width.'%'], 'cssClass' => ['checkbox', 'ids']], 
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
        $columns[] = $colDef;
    }
    
    // setting same width for columns to keep the html table from autoresizing of columns
    $min_width = floor((100 - $min_width*2) / (count($columns) - 2));
    for($i = 2; $i < count($columns); $i ++) {
        $columns[$i]['options']['width'] = $min_width.'%';
    }
echo '?', '>';
<div id="table" class="echo '<', '?'; $show_tree ? 'with_tree' : '' echo '?', '>';">
echo '<', '?'; $a = GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{summary}\n{pager}", 
        'columns' => $columns
    ]); 
    echo '?', '>';
</div>

echo '<', '?php'; $form = yii\widgets\ActiveForm::begin(['method' => 'post', 'id'=>'formList', 'action' => Url::current()]); echo '?', '>';
echo '<', '?php'; yii\widgets\ActiveForm::end(); echo '?', '>';

<!-- end list of table records -->


<!-- tree window -->

echo '<', '?php';

use execut\widget\TreeView;
use yii\web\JsExpression;

if ($searchModel::withGroups && $show_tree) {
echo '?', '>';

<div id="tree2">

echo '<', '?php';


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
echo '?', '>';

</div>

echo '<', '?php';
}
echo '?', '>';


<!-- end tree window -->

<script>
    if (typeof(listForm) == 'object') {
        listForm.init();
    }
</script>

echo '<', '?php'; Pjax::end(); echo '?', '>';


<!-- columns order and visibility management -->

<div class="modal fade" id="modalColumns" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      echo '<', '?php'; $form = yii\widgets\ActiveForm::begin(['action' => Url::to(['columns'])]); echo '?', '>';

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reorder columns by drag-n-drop</h4>
      </div>
      <div class="modal-body">

        <div id="tabs">
        
            <table class="table table-striped">
                <tbody>
                    <tr><td><b>Columns</b></td></tr>
        echo '<', '?php';
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
        echo '?', '>';
                </tbody>
            </table>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        echo '<', '?'; Html::submitButton('Save Columns', ['class' => 'btn btn-primary']) echo '?', '>';
      </div>
      
      echo '<', '?php'; yii\widgets\ActiveForm::end(); echo '?', '>';
      
    </div>
  </div>
</div>


<!-- end columns order and visibility management -->
