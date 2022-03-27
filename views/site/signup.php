<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">


    <div class="row mt-5">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-8">
            <?php $form = ActiveForm::begin([
            'id' => 'form-signup',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-4 form-control'],
                'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
            ],
        ]); ?>

                <?= $form->field($model, 'username')->label('Имя пользователя')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email')->label('Email') ?>

                <?= $form->field($model, 'password')->label('Пароль')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-dark', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>