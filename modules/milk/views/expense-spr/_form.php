<?php

use app\modules\milk\models\ExpenseSpr;
use app\modules\milk\models\Products;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Products $model */
/** @var yii\widgets\ActiveForm $form */
$types = ExpenseSpr::getExpenseTypes();
$products = Products::getAll();
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(['' => 'Tanlang...'] + $types) ?>

    <?= $form->field($model, 'product_code')->dropDownList(['' => 'Tanlang...'] + $products) ?>

    <?= $form->field($model, 'status')->checkbox(['checked' => $model ? $model->status : true]) ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => ($model->created_at ? $model->created_at : date('Y-m-d H:i:s'))]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
    .field-expensespr-created_at,
    .field-expensespr-updated_at {
        display: none;
    }
</style>