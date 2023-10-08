<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Days $model */

$this->title = date('d.m.Y', strtotime($model->day));
$this->params['breadcrumbs'][] = ['label' => 'Kunlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="days-view card">
    <div class="card-body">

    </div>
</div>