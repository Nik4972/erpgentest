<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AddressType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'notion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'registry' => 'Registry', 'logistic' => 'Logistic', 'other' => 'Other', ], ['prompt' => '']) ?>

    <?= !$model->isNewRecord ? $form->field($model, 'status')->dropDownList([ '1' => 'Actual','Archive','Deleted']) : '' ?>

    <?= $field = $form->field($model, 'parent')->label('Group')->dropDownList($model->getGroups(), 
        ['prompt' => ['text' => '', 'options' => ['value' => '0', 'class' => 'prompt', 'label' => '']],
        'options' => [$model->parent => ['selected' => 'selected']]]) ?>

    <?= $form->field($model, 'group')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
