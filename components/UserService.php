<?php

namespace app\components;

use Yii;
use yii\web\User as WebUser;
use app\models\User;
use yii\rbac\Role;

class UserService 
{
    /**
     * @var int
     */
    const USER_ROLE_ADMIN = 'elder';



    /**
     * Возвращает модель пользователя
     * 
     * @return User
     */
    public static function getUserModel(): User
    {
        if (! static::isGuest()) {
            return Yii::$app->user->getIdentity();
        }
        
        return new User;
    }

    public static function isGuest(): bool
    {
        return (bool) Yii::$app->user->isGuest;
    }

    public static function isElder(): bool
    {
        return (bool) Yii::$app->user->can('elder');
    }

    public static function isCitizen(): bool
    {
        return (bool) Yii::$app->user->can('citizen');
    }

    /**
     * Возвращает имя пользователя
     * 
     * @return null|string
     */
    public static function getUserName()
    {
        return static::getUserModel()->username;
    }

    /**
     * Undocumented function
     *
     * @param integer $userId
     * @param string $default
     * @return string
     */
    public static function hasAdminRoleById(int $userId): bool
    {
        return Yii::$app->authManager->checkAccess($userId, static::USER_ROLE_ADMIN);
    }

    
}