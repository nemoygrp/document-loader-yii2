<?php

/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\ListView;


$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="mt-5 pl-4 mb-5 bg-smooth-1"> Всего загружено файлов</div>
<table class="table">
  <thead>
    <tr class="bg-smooth-1">
      <th scope="col">За день</th>
      <th scope="col">За месяц</th>
      <th scope="col">За год</th>
    </tr>
  </thead>
  <tbody>
    <tr class="bg-smooth-2">
      <td><?= $service->statToDay ?></td>
      <td><?= $service->statToWeek ?></td>
      <td><?= $service->statToMonth ?></td>
    </tr>

  </tbody>
</table>
<div class="mt-5 pl-4 mb-5 bg-smooth-1"> Соотношение публичных, условно-приватных и приватных документов </div>

<table class="table">
  <thead>
    <tr class="bg-smooth-1">
      <th scope="col">За день</th>
      <th scope="col">За месяц</th>
      <th scope="col">За год</th>
    </tr>
  </thead>
  <tbody>
    <tr class="bg-smooth-2">
      <td><?= $service->ratioToDay ?></td>
      <td><?= $service->ratioToWeek ?></td>
      <td><?= $service->ratioToMonth ?></td>
    </tr>

  </tbody>
</table>


