<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\ProductsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Maxsulotlar';
$this->params['breadcrumbs'][] = $this->title;
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
                    'attribute' => 'code',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:13%;vertical-align: middle;'],
                ],
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:22%;vertical-align: middle;'],
                ],
                [
                    'attribute' => 'expense_code',
                    'format' => 'raw',
                    'filter' => $xomashyos,
                    'contentOptions' => ['style' => 'width:22%;vertical-align: middle;'],
                    'value' => function ($data) use ($xomashyos) {
                        return strlen($data->expense_code)>0 ? (isset($xomashyos[$data->expense_code]) ? $xomashyos[$data->expense_code] : $data->expense_code) : "";
                    }
                ],
                [
                    'attribute' => 'ord',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:6%;vertical-align: middle;text-align:center;'],
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