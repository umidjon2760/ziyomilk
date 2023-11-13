<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Products $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Xarajatlar spravochnigi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="products-view card">
    <div class="card-body">
        <p>
            <?= Html::a('O\'zgartirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('O\'chirish', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'O\'chirilgan ma\'lumotlar tiklanmaydi. Rostdan ham o\'chirmoqchimisiz?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'code',
                'name',
                'status',
                'created_at',
                'updated_at',
            ],
        ]) ?>
    </div>
</div>