<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AddressType */

$this->title = 'Update Macroregion GEO: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Macroregions GEO', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="address-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
