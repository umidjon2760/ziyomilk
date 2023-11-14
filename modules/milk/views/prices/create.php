<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Prices $model */

$this->title = 'Yangi narx belgilash';
$this->params['breadcrumbs'][] = ['label' => 'Narxlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-create card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>