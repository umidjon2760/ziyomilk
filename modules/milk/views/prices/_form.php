<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\milk\models\Products;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Prices $model */
/** @var yii\widgets\ActiveForm $form */
$products = Products::getAll();
?>

<div class="prices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_code')->widget(Select2::class, [
            'data' => $products,
            'options' => ['prompt' => 'Tanlang ...', 'multiple' => false],
            'theme' => Select2::THEME_BOOTSTRAP,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'status')->checkbox(['checked' => $model ? $model->status : true]) ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => ($model->created_at ? $model->created_at : date('Y-m-d H:i:s'))]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<style>
    .field-prices-photo,
    .field-prices-created_at,
    .field-prices-updated_at {
        display: none;
    }
</style>