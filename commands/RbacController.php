<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $uploadDoc = $auth->createPermission('uploadDoc');
        $uploadDoc->description = 'Загрузка новых документов';
        $auth->add($uploadDoc);

        $viewAuthDoc = $auth->createPermission('viewAuthDoc');
        $viewAuthDoc->description = 'Просмотр и правка доступа к приватных документов';
        $auth->add($viewAuthDoc);

        $viewUserAccess = $auth->createPermission('viewUserAccess');
        $viewUserAccess->description = 'Просмотр и правка прав пользователей';
        $auth->add($viewUserAccess);

        $citizen = $auth->createRole('citizen');
        $auth->add($citizen);
        $auth->addChild($citizen, $uploadDoc);
        $auth->addChild($citizen, $viewAuthDoc);

        $elder = $auth->createRole('elder');
        $auth->add($elder);
        $auth->addChild($elder, $viewUserAccess);
        $auth->addChild($elder, $citizen);

        $auth->assign($citizen, 2);
        $auth->assign($elder, 1);
    }
}