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
         <input type='checkbox' id='".$table['id']."' name='list_tables[]' value='".$table['id']."' checked>
         <label for='".$table['id']."'>".$table['id']."</label>
        </div>";
 }

  echo "<br /><input type='submit' value='Create'>";

  //echo "</form>";
  
ActiveForm::end();

?>