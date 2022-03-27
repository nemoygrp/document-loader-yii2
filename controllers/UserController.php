<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\UploadForm;
use app\models\SignupForm;
use app\components\DataProviderService;
use app\components\UserService;
use app\models\User;
use yii\web\UploadedFile;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new \Exception('У вас нет доступа к этой странице');
                },
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        return $this->render('users', [
            'dataProvider' => DataProviderService::getProvider('config_users'),
        ]);
    }

    /**
     * Повышение пользователя до админа
     * 
     * @param integer $id
     * @return void
     */
    public function actionRaise(int $id)
    {
        $auth = Yii::$app->authManager;
        $auth->revokeAll($id);
        $adminRole = $auth->getRole(UserService::USER_ROLE_ADMIN);
        $auth->assign($adminRole, $id);

        return $this->redirect('/user');
    }
   

    public function actionFlush(int $id)
    {
        $this->findUserModel($id)->delete();

        return $this->redirect('/user');
    }

    /**
     * Поиск модели запроса.
     * 
     * @param  int $requestId
     * @return PartnerRequest $request
     * @throws NotFoundException
     */
    private function findUserModel(int $userId)
    {
        $request = User::findOne($userId);

        if (empty($request)) {
            return abort(404);
        }

        return $request;
    }
}

