<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Generator';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Select table for generate:
    </p>
</div>


<?php

$form = ActiveForm::begin(['action' => ['generator2']]);

 
 //echo '<form id="select" action="index.php?r=generator/generator2" method="post">';
 // echo '<input type="hidden" name="_csrf" value="'.Yii::$app->request->getCsrfToken().'" />';
 
 foreach ($tables as $table) {
  echo "<div>
         <input class='ids' type='checkbox' id='".$table['id']."' name='list_tables[]' value='".$table['id']."' xchecked>
         <label for='".$table['id']."'>".$table['id']."</label>
        </div>";
 }
?>
<div><input type="checkbox" onchange="$('.ids').prop('checked', $(this).prop('checked'))"/> Check / Uncheck All</div>
<?php
  echo "<br /><input type='submit' value='Create'>";

  //echo "</form>";
  
ActiveForm::end();

?>