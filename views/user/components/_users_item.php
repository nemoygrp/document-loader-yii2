<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\UserService;

//\app\helpers\DebugHelper::dd(\app\components\UserService::printAdminRoleName($model->id));
$isAdmin = UserService::hasAdminRoleById($model->id);
?>

<div class="list_item_block bg-smooth-2 row">
    <div class="col-lg-1 font-weight-bold"><?= $model->id ?></div>
    <div class="col-lg-2"><?= $model->username ?></div>
    <div class="col-lg-3"><?= $model->email ?></div>
    <div class="col-lg-2"><?= Yii::$app->formatter->asDate($model->created_at ,'php:d-m-Y')  ?></div>
    <div class="col-lg-2"><?= $model->printDocumentsCount() ?></div>
    <div class="col-lg-1"><?= 
        (! $isAdmin) ? Html::a('Повысить', Url::to(['/user/raise/', 'id' => $model->id])) : Html::tag('span', '(админ)')?> 
    </div>
    <div class="col-lg-1"><?= 
        (! $isAdmin) ? Html::a('Удалить', Url::to(['/user/flush/', 'id' => $model->id])) : Html::tag('span', '')?> 
    </div>
</div>

