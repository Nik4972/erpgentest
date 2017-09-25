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

$form = ActiveForm::begin(['id'     => 'form_checkbox',
                           'action' => 'generator2'
                          ]);

 foreach ($tables as $table) {
  echo "<div>
         <input type='checkbox' id='".$table['id']."' name='list_tables[]' value='".$table['id']."' >
         <label for='".$table['id']."'>".$table['id']."</label>
        </div>";
 }
 
?>
 <br /><br />
 <input  id="checkAll" type="checkbox" onclick="check_all();" >Отметить все

 <br /><br />
 <br /><input type='submit' value='Create'>

<?php
ActiveForm::end();
?>

<script type="text/javascript">

  function check_all() {

        $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
     });
  }
 
 </script>

