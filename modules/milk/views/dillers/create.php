<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Dillers $model */

$this->title = 'Yangi diller qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'Dillers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dillers-create card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>