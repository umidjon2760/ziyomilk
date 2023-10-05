<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Products $model */

$this->title = 'Yangi';
$this->params['breadcrumbs'][] = ['label' => 'Maxsulotlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create card">
    <div class='card-body'>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>