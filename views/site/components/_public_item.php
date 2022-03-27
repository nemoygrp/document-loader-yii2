<?php
use yii\helpers\Html;
use yii\helpers\Url;

//\app\helpers\DebugHelper::dd($model);
?>

<div class="list_item_block bg-smooth-2 row">
    <div class="col-lg-3"><?= $model->name . '.' . $model->extension ?></div>
    <div class="col-lg-3"><?= $model->printUserName() ?></div>
    <div class="col-lg-3"><?= Yii::$app->formatter->asDate($model->created_at ,'php:H:i d-m-Y') ?></div>
    <div class="col-lg-2"><?= $model->printSizeKb()?> </div>
    <div class="col-lg-1"> <?= 
        Html::a(
            'Скачать', 
            Url::to(['document/get-file']), [
            'data-method' => 'POST', 
            'data-params' => [
                'docId' => $model->id,
            ], 
            ]) ?> 
    </div>
</div>