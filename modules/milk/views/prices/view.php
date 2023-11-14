<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Products $model */

$this->title = $model->product->name;
$this->params['breadcrumbs'][] = ['label' => 'Narxlar', 'url' => ['index']];
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
                [
                    'attribute' => 'product_code',
                    'value' => function ($data) {
                        return $data->product->name;
                    }
                ],
                'price',
                'status:boolean',
                'photo',
                'created_at',
                'updated_at',
            ],
        ]) ?>

    </div>
</div>