<?php

/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\ListView;

$checkboxTemplate = "<div class=\"col-lg-6 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-6\">{error}</div>";

$this->title = 'Загрузка документа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index d-flex justify-content-center row" >
  <div class="form-upload block-upload-form col-lg-10">
    <div class="row ">
    <div class="col-lg-4"></div>
      <div class="col-lg-8 pl-5">
          <?php $form = ActiveForm::begin([
            'id' => 'form-upload',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-2 form-control'],
                'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
            ],
          ]); ?>

            <?= $form->field($model, 'document')->label('Добавить файл')->fileInput(['lang'=>'ru']) ?>
            <?= $form->field($model, 'public')->checkbox([
                'template' => $checkboxTemplate,
            ])->label('Сделать общедоступным') ?>
    
            <?= $form->field($model, 'private')->checkbox([
                'template' => $checkboxTemplate,
            ])->label('Доступный только мне') ?>
      
            <div class="form-group pl-5">
              <?= Html::submitButton('Сохранить', ['class' => 'btn btn-light', 'name' => 'upload-button']) ?>
            </div>
          <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
<div class="mt-5 pl-4"> Последние загруженные файлы пользователем - <b><?= Yii::$app->user->identity->username ?></b></div>
  <?= ListView::widget([
      'dataProvider' => $dataProvider,
      'options' => [
          'tag' => 'div',
          'class' => 'body-content d-flex justify-content-center flex-column col-lg-8',
          'id' => 'last-upload-list',
      ],
      'layout' => '<div class="list-header-block bg-smooth-1 row">
          <div class="col-lg-5">Название</div>
          <div class="col-lg-4">Дата загрузки</div>
          <div class="col-lg-2">Объем</div>
          <div class="col-lg-1"></div>
      </div>{items}',
      'itemView' => 'components/_last_upload_item',
  ]); ?>

