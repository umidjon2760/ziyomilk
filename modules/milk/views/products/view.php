<?php

use app\modules\milk\models\ExpenseSpr;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Products $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Maxsulotlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$xomashyos = ExpenseSpr::getXomashyos();
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
                [
                    'attribute' => 'expense_code',
                    'value' => function($data) use ($xomashyos){
                        return isset($xomashyos[$data->expense_code]) ? $xomashyos[$data->expense_code] : $data->expense_code;
                    }
                ],
                'ord',
                'status',
                'created_at',
                'updated_at',
            ],
        ]) ?>
    </div>
</div>