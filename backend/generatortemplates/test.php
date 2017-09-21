<?php

echo '<', '?php';
$className = ucfirst($name_tables['notion']);
$moduleName = $name_tables['module'] ? $name_tables['module'] : 'core';
?>

namespace backend\<?= $moduleName ?>\models;

use Yii;

/**
 * <?= $className ?> represents the model behind the search form about `backend\<?= $moduleName ?>\models\<?= $className ?>.
 */
class <?= $className ?> extends \yii\db\ActiveRecord
{
}
