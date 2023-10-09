<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\milk\models\Days $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="days-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'day')->widget(\kartik\date\DatePicker::classname(), [
        'pickerIcon' => '<i class="fas fa-calendar-alt text-primary"></i>',
        'removeIcon' => '<i class="fas fa-trash text-danger"></i>',
        'options' => [
            'required' => 'required',
            'readonly' =>true
        ],
        'pluginOptions' => [
            'todayHighlight' => true,
            // 'type'=>DatePicker::TYPE_INLINE,
            'daysOfWeekDisabled' => [0, 6],
            // 'calendarWeeks'=>true,
            // 'todayBtn'=>true,
            'autoclose' => true,
            'startDate' => date('Y-m-d'),
            'required' => 'required',
            'format' => 'yyyy-mm-dd',
            'minDate' => '-1d',
        ],

    ]) ?>

    <?= $form->field($model, 'status')->checkbox(['checked' => $model ? $model->status : true]) ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => ($model ? $model->created_at : date('Y-m-d H:i:s'))]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .field-days-created_at,
    .field-days-updated_at {
        display: none;
    }
</style>