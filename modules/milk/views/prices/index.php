<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\milk\models\Products;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\ProductsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Narxlar';
$this->params['breadcrumbs'][] = $this->title;
$products = Products::getAll();
?>
<div class="products-index card">
    <div class="card-body">
        <p>
            <?= Html::a('Yangi', ['create'], ['class' => 'btn btn-success']) ?>
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

                // [
                //     'attribute' => 'id',
                //     'format' => 'raw',
                //     'contentOptions' => ['style' => 'width:4%;vertical-align: middle;text-align:center;'],
                // ],
                [
                    'attribute' => 'product_code',
                    'format' => 'raw',
                    'filter' => ['' => 'Танланг'] + $products,
                    'filterType' => GridView::FILTER_SELECT2,
                    'contentOptions' => ['style' => 'width:40%;vertical-align: middle;'],
                    'value' => function ($data) {
                        return $data->product->name;
                    }
                ],
                [
                    'attribute' => 'price',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:12%;vertical-align: middle;text-align:center;'],
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => [1 => 'Aktiv', 0 => 'Noaktiv'],
                    'contentOptions' => ['style' => 'width:10%;vertical-align: middle;text-align:center;'],
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
                    'contentOptions' => ['style' => 'width:12%;vertical-align: middle;text-align:center;'],
                    'value' => function ($data) {
                        return date('d.m.Y H:i:s', strtotime($data->created_at));
                    }
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:12%;vertical-align: middle;text-align:center;'],
                    'value' => function ($data) {
                        return date('d.m.Y H:i:s', strtotime($data->updated_at));
                    }
                ],
                ['class' => 'kartik\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>