<?php

/** @var yii\web\View $this */

use yii\widgets\ListView;

?>
    <div class="mt-5 pl-4 mb-5"> Доступные файлы</div>
<?= 
ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'tag' => 'div',
        'class' => 'body-content d-flex justify-content-center flex-column col-lg-12',
        'id' => 'last-upload-list',
    ],
    'layout' => '<div class="list-header-block bg-smooth-1 row">
        <div class="col-lg-3">Название</div>
        <div class="col-lg-3">Имя пользователя</div>
        <div class="col-lg-3">Дата загрузки</div>
        <div class="col-lg-2">Объем</div>
        <div class="col-lg-1"></div>
    </div>{items}<br>
    <div class="list-control-panel"> {pager}{summary}</div>',
    'itemView' => 'components/_public_item',
    'pager' => [
        'nextPageLabel' => 'Следующая',
        'prevPageLabel' => 'Предыдущая',
        'maxButtonCount' => 3,
    ],
]); 
?>