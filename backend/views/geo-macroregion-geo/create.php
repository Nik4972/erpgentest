<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AddressType */

$this->title = 'Create Macroregion GEO';
$this->params['breadcrumbs'][] = ['label' => 'Macroregions GEO', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
