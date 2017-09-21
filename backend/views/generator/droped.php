<?php

use yii\helpers\Html;

$this->title = 'Generator';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        You removed tables:
    </p>
</div>

<?php

foreach ($tables as $table) {

	echo $table."<br />";
}

?>