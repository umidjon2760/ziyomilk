<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Days $model */

$this->title = 'Update Days: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Days', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="days-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
