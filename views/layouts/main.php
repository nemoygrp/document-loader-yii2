<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php $this->registerCsrfMetaTags() ?>

        <title><?= Html::encode($this->title) ?></title>

        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

        <header>
            <?php
            NavBar::begin([
                'brandLabel'        => Html::img('@img/logo.jpg', ['height' => 120]),
                'collapseOptions'   => ['class' => 'justify-content-end'],
                'brandUrl'          => Yii::$app->homeUrl,
                'options'           => [
                    'class' => 'navbar navbar-expand-md navbar-light bg-white flex',
                ],
            ]);
            echo Nav::widget([
                'options'   => ['class' => 'navbar-nav navbar-right text-monospace'],
                'activateItems' => false,
                'items'     => [
                    ['label' => 'Главная',      'url' => ['/site/index']],
                    ['label' => 'Архив',        'url' => ['car/index'], 'visible' => !Yii::$app->user->isGuest],
                    ['label' => 'Регистрация',  'url' => ['site/signup'], 'visible' => Yii::$app->user->isGuest],
                    Yii::$app->user->isGuest ? (
                    ['label' => 'Войти', 'url' => ['/site/login']]
                    ) : (
                        '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Выйти (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'nav-link bg-gradient-dark rounded btn-logout']
                        )
                        . Html::endForm()
                        . '</li>'
                    )
                ],
            ]);
            NavBar::end();
            ?>
        </header>

        <main role="main" class="flex-shrink-0">
            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </main>

        <footer class="footer mt-auto py-3 text-muted">
            <div class="container">
                <p class="float-left">&copy; <?= Yii::$app->name . ' ' .date('Y') ?></p>
            </div>
        </footer>

    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
