<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeTypecastBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use app\helpers\DateHelper;
use app\models\User;
use yii\db\ActiveQuery;

class Document extends ActiveRecord
{
    /**
     * @var boolean
     */
    public $public = false;

    /**
     * @var boolean
     */
    public $private = false;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'documents';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => TimestampBehavior::class,
                    'value' => Yii::$app->formatter->asDate('now'),
                ],
                'typecast' => [
                        'class' => AttributeTypecastBehavior::class,
                        'attributeTypes' => [
                            'public' => AttributeTypecastBehavior::TYPE_INTEGER,
                            'private' => AttributeTypecastBehavior::TYPE_INTEGER,
                        ],
                        'typecastAfterValidate' => true,
                        'typecastBeforeSave' => false,
                        'typecastAfterFind' => false,
                    ],
            ];
    }

    public function user()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
 
    /**
     * Возвращает закодированное название файла
     *
     * @return string
     */
    public function getCryptFilename(): string 
    {
        return (string) md5($this->id) . '.storage';
    }

    /**
     * Получение полного имени документа
     *
     * @return string
     */
    public function getFullFilename(): string 
    {
        return $this->name . '.' . $this->extension;
    }

    /**
     * Вывод имени пользователя
     *
     * @param string $default
     * @return string
     */
    public function printUserName(string $default = 'Не известно'): string 
    {
        return $this->hasUserName() ? $this->getUserName()->username : $default;
    }
    
    /**
     * Вывод объема в килобайтах
     *
     * @param string $kb
     * @return string
     */
    public function printSizeKb(string $kb = ' Kb'): string 
    {
        return ($this->size / 1000) . $kb;
    }
    

    /**
     * Проверка есть ли пользователь
     *
     * @return boolean
     */
    public function hasUserName(): bool 
    {
        return $this->user()->exists();
    }

    /**
     * Получение пользователя
     *
     * @return User
     */
    public function getUserName(): User 
    {
        return $this->user()->one();
    }
}
