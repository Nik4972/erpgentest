<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GeoCountry */

$this->title = 'Update Geo Country: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Geo Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="geo-country-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
