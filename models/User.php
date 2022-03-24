<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use app\helpers\DateHelper;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Undocumented function
     *
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }

    public static function roles()
    {
        return [
            self::ROLE_USER => Yii::t('app', 'User'),
            self::ROLE_ADMIN => Yii::t('app', 'Admin'),
            self::ROLE_MANAGER => Yii::t('app', 'Manager'),
        ];
    }

    /**
     * Название роли
     * @param int $id
     * @return mixed|null
     */
    public function getRoleName(int $id)
    {
        $list = self::roles();
        return $list[$id] ?? null;
    }

    public function isAdmin()
    {
        return ($this->role == self::ROLE_ADMIN);
    }

    public function isManager()
    {
        return ($this->role == self::ROLE_MANAGER);
    }

    public function isUser()
    {
        return ($this->role == self::ROLE_USER);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => TimestampBehavior::class,
                    'value' => DateHelper::getFormattedDate('now','Y-m-d H:i:s'),
                ],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }


    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

        /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

        /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
