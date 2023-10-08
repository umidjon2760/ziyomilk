<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Days $model */

$this->title = 'Yangi';
$this->params['breadcrumbs'][] = ['label' => 'Kunlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="days-create card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>