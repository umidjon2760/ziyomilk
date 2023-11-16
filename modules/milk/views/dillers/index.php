<?php

use app\modules\milk\models\Dillers;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\DillersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Dillerlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dillers-index card">
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
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:30%;vertical-align: middle;'],
                ],
                // 'phone2',
                //'tg_address',
                [
                    'attribute' => 'car',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:10%;vertical-align: middle;text-align:center;'],
                ],
                [
                    'attribute' => 'car_number',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:10%;vertical-align: middle;text-align:center;'],
                ],
                //'photo',
                //'created_at',
                //'updated_at',
                //'status:boolean',
                [
                    'attribute' => 'phone',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:10%;vertical-align: middle;text-align:center;'],
                ],
                [
                    'attribute' => 'address',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:23%;vertical-align: middle;'],
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => [1 => 'Aktiv', 0 => 'Noaktiv'],
                    'contentOptions' => ['style' => 'width:7%;vertical-align: middle;text-align:center;'],
                    'value' => function ($data) {
                        if ($data->status) {
                            return 'Aktiv';
                        } else {
                            return 'Noaktiv';
                        }
                    }
                ],
                ['class' => 'kartik\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>