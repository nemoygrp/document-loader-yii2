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
use app\models\Document;
use yii\web\UploadedFile;

class DocumentController extends Controller
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
        $form = new UploadForm();

        if (Yii::$app->request->isPost) {
            $form->load(Yii::$app->request->post());
            $form->document = UploadedFile::getInstance($form, 'document');
         
            if ($form->handle()) {
                return $this->goHome();
            }
        }

        return $this->render('upload', [
            'model' => $form,
            'user' => Yii::$app->user->getIdentity(),
            'dataProvider' => DataProviderService::getProvider('last_update', 4),
        ]);
    }

    /**
     * Undocumented function
     *
     * @param integer $docId
     * @return void
     */
    public function actionGetFile()
    {
        $model = Document::findOne(Yii::$app->request->post()['docId']);
        $storagePath = Yii::getAlias('@storage');

        return Yii::$app->response->sendFile($storagePath.'/' . $model->getCryptFilename(), $model->getFullFilename());
    }
   
}

