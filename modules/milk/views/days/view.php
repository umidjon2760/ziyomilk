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
<div class="card collapsed-card" id="prductions">
    <div class="card-header">
        <button type="button" style="width:100%;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <h3 class="card-title" style="color:black;">Ishlab chiqarish <i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body" style="display: block;">
        <?php
        $productions = $model->productions;
        debug($productions);
        ?>
    </div>
</div>

<div class="card collapsed-card" id="dillers">
    <div class="card-header">
        <button type="button" style="width:100%;" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <h3 class="card-title" style="color:black;">Dillerlar <i class="fas fa-plus"></i></button>
    </div>
    <div class="card-body">
        dfdss sfsfsfs fsfsf
    </div>
</div>