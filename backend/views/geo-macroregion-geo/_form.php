<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AddressType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= !$model->isNewRecord ? $form->field($model, 'status')->dropDownList([ '1' => 'Actual','Archive','Deleted']) : '' ?>

    <?= $field = $form->field($model, 'group_id')->label('Group')->dropDownList($model->getGroups(), ['prompt' => ['text' => '', 'options' => ['value' => '0', 'class' => 'prompt', 'label' => '']]]) ?>

    <?= $form->field($model, 'is_group')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
