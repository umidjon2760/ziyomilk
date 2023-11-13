<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Dillers $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dillerlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dillers-view card">
    <div class="card-body">
    <p>
        <?= Html::a('O\'zgartirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O\'chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Rostdan ham o\'chirmoqchimisiz?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'car',
            'car_number',
            'phone',
            'phone2',
            'tg_address',
            'address',
            'photo',
            'created_at',
            'updated_at',
            'status:boolean',
        ],
    ]) ?>
</div>
</div>
