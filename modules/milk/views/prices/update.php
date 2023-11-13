<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Prices $model */

$this->title = 'O\'zgartirish: ' . $model->product->name;
$this->params['breadcrumbs'][] = ['label' => 'Narxlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O\'zgartirish';
?>
<div class="prices-update card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>