<?php

use app\modules\milk\models\ExpenseSpr;
use app\modules\milk\models\Products;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;

$types = ExpenseSpr::getExpenseTypes();
$products = Products::getAll();

/** @var yii\web\View $this */
/** @var app\modules\milk\models\ExpenseSprSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Xarajatlar spravochnigi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-spr-index card">
    <div class="card-body">
        <p>
            <?= Html::a('Yangi qo\'shish', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'resizableColumns' => true,
            'showPageSummary' => false,
            'panel' => [
                'type' => 'info',
                'heading' => $this->title,
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],

                // 'id',
                [
                    'attribute' => 'code',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:15%;vertical-align: middle;'],
                ],
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:30%;vertical-align: middle;'],
                ],
                [
                    'attribute' => 'type',
                    'format' => 'raw',
                    'filter' => $types,
                    'contentOptions' => ['style' => 'width:5%;vertical-align: middle;text-align:center;'],
                    'value' => function ($data) use ($types) {
                        return isset($types[$data->type]) ? $types[$data->type] : $data->type;
                    }
                ],
                [
                    'attribute' => 'product_code',
                    'format' => 'raw',
                    'filter' => $products,
                    'contentOptions' => ['style' => 'width:25%;vertical-align: middle;text-align:center;'],
                    'value' => function ($data) use ($products) {
                        return isset($products[$data->product_code]) ? $products[$data->product_code] : $data->product_code;
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => [1 => 'Aktiv', 0 => 'Noaktiv'],
                    'contentOptions' => ['style' => 'width:5%;vertical-align: middle;text-align:center;'],
                    'value' => function ($data) {
                        if ($data->status) {
                            return 'Aktiv';
                        } else {
                            return 'Noaktiv';
                        }
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:10%;vertical-align: middle;text-align:center;'],
                    'value' => function ($data) {
                        return date('d.m.Y H:i:s', strtotime($data->created_at));
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:10%;vertical-align: middle;text-align:center;'],
                    'value' => function ($data) {
                        return date('d.m.Y H:i:s', strtotime($data->updated_at));
                    }
                ],
                ['class' => 'kartik\grid\ActionColumn'],
            ],
        ]); ?>
    </div>

</div>