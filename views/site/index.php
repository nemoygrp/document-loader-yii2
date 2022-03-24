<?php

/** @var yii\web\View $this */
use yii\helpers\Html;

//$this->title = 'My Yii Application';
?>
<div class="site-index d-flex justify-content-center" >
<?php if (\Yii::$app->user->can('uploadDoc')) {
    echo 'dsdsdsdsdd';
}?>
    <div class="row mt-5">
    <form>
        <div class="form-group">
            <label for="exampleFormControlFile1">Форма для загрузки документов</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>
    </form>
    </div>
</div>

<div class="body-content d-flex justify-content-center mt-5">
        <p>Тут будет таблица с загруженными документами</p>
</div>
