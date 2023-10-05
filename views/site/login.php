<?php

use yii\helpers\Html;
?>

<div id="card" class="card">
    <div class="card-body login-card-body p-4">
        <h3 class="login-box-msg">KIRISH</h3>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'username', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => 'Login']) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('Parol')]) ?>

        <div class="row">
            <div class="col-12">
                <?= Html::submitButton('Kirish', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>
        <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
</div>

<style>
    #card {
        width:400px;
    }

    body::before {
        content: "";
        background-image: linear-gradient(rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.43)), url('files/images/login_back_image.jpeg');
        background-repeat: no-repeat;
        background-size: cover;
        position: absolute;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
    }
</style>