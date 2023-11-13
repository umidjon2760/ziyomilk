<?php

use app\modules\milk\models\ExpenseSpr;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;

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
                'contentOptions' => ['style' => 'width:20%;vertical-align: middle;'],
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:43%;vertical-align: middle;'],
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => [1=>'Aktiv',0=>'Noaktiv'],
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
