<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Войти';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login ">
    <div class="row mt-5">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-4 form-control'],
                'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
            ],
        ]);?>
        <?= $form->field($model, 'username')->label('Имя пользователя')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->label('Пароль')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
        <div class="form-group">
            <div>
                <?= Html::submitButton('Войти', ['class' => 'btn btn-dark', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>