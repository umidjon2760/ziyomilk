<?php

use app\modules\milk\models\ExpenseSpr;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Products $model */
/** @var yii\widgets\ActiveForm $form */
$xomashyos = ExpenseSpr::getXomashyos();
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expense_code')->widget(Select2::class, [
        'data' => $xomashyos,
        'options' => ['prompt' => 'Tanlang ...', 'multiple' => false],
        'theme' => Select2::THEME_BOOTSTRAP,
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'status')->checkbox(['checked' => $model ? $model->status : true]) ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => ($model->created_at ? $model->created_at : date('Y-m-d H:i:s'))]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
    .field-products-created_at,
    .field-products-updated_at {
        display: none;
    }
</style>