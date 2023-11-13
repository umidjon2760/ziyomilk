<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Products $model */

$this->title = 'O\'zgartirish: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Xarajatlar spravochnigi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O\'zgartirish';
?>
<div class="products-update card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>