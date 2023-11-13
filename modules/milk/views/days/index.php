<?php

use app\modules\milk\models\Days;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\DaysSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kunlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="days-index card">
    <div class="card-body">
        <p>
            <?= Html::a('Yangi kun ochish', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => false,
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
                    'attribute' => 'day',
                    'format' => 'raw',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'name' => 'DaysSearch[day]',
                        'value' => ArrayHelper::getValue($_GET, "DaysSearch.day"),
                        'readonly' => true,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ]
                    ]),
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                    'value' => function ($data) {
                        return date('d.m.Y', strtotime($data->day));
                    }
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
                // [
                //     'attribute' => 'created_at',
                //     'format' => 'raw',
                //     'contentOptions' => ['style' => 'width:15%;vertical-align: middle;text-align:center;'],
                //     'value' => function ($data) {
                //         return date('d.m.Y H:i:s', strtotime($data->created_at));
                //     }
                // ],
                // [
                //     'attribute' => 'updated_at',
                //     'format' => 'raw',
                //     'contentOptions' => ['style' => 'width:15%;vertical-align: middle;text-align:center;'],
                //     'value' => function ($data) {
                //         return date('d.m.Y H:i:s', strtotime($data->updated_at));
                //     }
                // ],
                [
                    'header' => 'Ko\'rish',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:8%;vertical-align: middle;text-align:center;'],
                    'value' => function ($data) {
                        return "<a href='?r=milk/days/view&id=" . $data->id . "' class='btn btn-info btn-sm'>Ko'rish</a>";
                    }
                ]
            ],
        ]); ?>
    </div>

</div>