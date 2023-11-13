<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Dillers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="dillers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'car')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'car_number')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'phone')->textInput() ?>
    
    <?= $form->field($model, 'phone2')->textInput() ?>
    
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'tg_address')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'status')->checkbox() ?>
    
    <?= $form->field($model, 'created_at')->textInput(['value' => ($model->created_at ? $model->created_at : date('Y-m-d H:i:s'))]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
    .field-dillers-created_at,
    .field-dillers-updated_at {
        display: none;
    }
</style>
