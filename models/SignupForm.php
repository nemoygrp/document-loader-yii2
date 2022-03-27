<?php
namespace app\models;

use yii\base\Model;
use app\models\User;
use Yii;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Обязательное поле'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой логин уже занят'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Обязательное поле'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такая почта уже занята.'],

            ['password', 'required', 'message' => 'Обязательное поле'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function handle(): ?User
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save(false);

        $auth = Yii::$app->authManager;
        $citizenRole = $auth->getRole('citizen');
        $auth->assign($citizenRole, $user->getId());

        return $user;
    }
}