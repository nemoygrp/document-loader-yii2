<?php

/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\ListView;


$this->title = 'Управление пользователями';
$this->params['breadcrumbs'][] = $this->title;
?>


<?= 
ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'tag' => 'div',
        'class' => 'body-content d-flex justify-content-center flex-column col-lg-12',
        'id' => 'last-upload-list',
    ],
    'layout' => '<div class="list-header-block bg-smooth-1 row">
        <div class="col-lg-1">#</div>
        <div class="col-lg-2">Имя</div>
        <div class="col-lg-3">Email</div>
        <div class="col-lg-2">Зарегистрирован</div>
        <div class="col-lg-2">Загружено</div>
        <div class="col-lg-1"></div>
        <div class="col-lg-1"></div>
        <div class="col-lg-1"></div>
    </div>{items}<br>
    <div class="list-control-panel"> {pager}{summary}</div>',
    'itemView' => 'components/_users_item',
    'pager' => [
        'nextPageLabel' => 'Следующая',
        'prevPageLabel' => 'Предыдущая',
        'maxButtonCount' => 3,
    ],
]); 
?>