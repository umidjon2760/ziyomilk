<?php

use app\modules\milk\models\Days;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\DaysSerach $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kunlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="days-index card">
    <div class="card-body">
        <p>
            <?= Html::a('Yangi', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'contentOptions' => ['style' => 'width:43%;vertical-align: middle;'],
                    'value' => function ($data) {
                        return date('d.m.Y', strtotime($data->day));
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
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
                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, Days $model, $key, $index, $column) {
                        if($action == 'view'){
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                        else{
                            return '';
                        }
                    }
                ],
            ],
        ]); ?>
    </div>

</div>