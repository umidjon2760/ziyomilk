<?php

use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Foydalanuvchilar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index card">
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => false,
            'resizableColumns' => true,
            'showPageSummary' => false,
            'panel' => [
                'type' => 'info',
                'heading' => 'Foydalanuvchilar',
            ],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],

                'id',
                'username',
                'password',
                'name',
                'phone',
                'address',
                'email:email',
                //'created_at',
                //'updated_at',
                ['class' => 'kartik\grid\ActionColumn'],
                // [
                //     'class' => ActionColumn::class,
                //     'urlCreator' => function ($action, Users $model, $key, $index, $column) {
                //         return Url::toRoute([$action, 'id' => $model->id]);
                //     }
                // ],
            ],
        ]); ?>
    </div>
</div>