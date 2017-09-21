<?php

echo '<', '?php';
$className = ucfirst($name_tables['notion']);
$moduleName = $name_tables['module'] ? $name_tables['module'] : 'core';
?>

namespace backend\<?= $moduleName ?>\controllers;

use backend\<?= $moduleName ?>\models\<?= $className ?>.
use yii\web\Controller;
use Yii;

/**
 * <?= $className ?>Controller implements the CRUD actions for <?= $className ?> model.
 */
class <?= $className ?>Controller extends Controller
{
    public function actionIndex()
    {
    }
}
