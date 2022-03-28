<?php

namespace app\components;

use Yii;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use app\models\Document;
use app\models\User;
use app\components\UserService;

class DataProviderService 
{
    /**
     * @var string
     */
    const DATA_PROVIDER_LAST_UPDATE = 'last_update';

    /**
     * @var string
     */
    const DATA_PROVIDER_ACCESS_DOCS = 'access_docs';

    /**
     * @var string
     */
    const DATA_PROVIDER_CONFIG_USER = 'config_users';
    
    /**
     * Метод получения дата провайдера
     *
     * @param string $type
     * @param integer $countOfPage
     * @return ActiveDataProvider
     */
    public static function getProvider(string $type, int $countOfPage = 10): ActiveDataProvider
    {
        $service = new self;

        switch ($type) {
            case static::DATA_PROVIDER_LAST_UPDATE:
                return $service->combineProvider(
                    $service->getDataProviderLastUpload(),
                    $countOfPage
                );
            case static::DATA_PROVIDER_ACCESS_DOCS:
                return $service->combineProvider(
                    $service->accessDirectionProvider(),
                    $countOfPage
                );
            case static::DATA_PROVIDER_CONFIG_USER:
                return $service->combineProvider(
                    $service->getDataProviderUsers(),
                    $countOfPage
                );
        }
    }

    /**
     * Метод сбора провайдера
     *
     * @param ActiveQuery $query
     * @param integer $countOfPage
     * @return ActiveDataProvider
     */
    private function combineProvider(ActiveQuery $query, int $countOfPage): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $countOfPage,
            ],
        ]);
    }

    /**
     * Формирование дата провайдера
     *
     * @return ActiveQuery
     */
    private function accessDirectionProvider(): ActiveQuery
    {
        if (UserService::isGuest()) {
            return $this->getDataProviderPublic();
        }

        return UserService::isElder() ? $this->getDataProviderElder() : $this->getDataProviderCitizen();
    }

    /**
     * Запрос получения данных для дата провайдера последних добавленных
     *
     * @return ActiveQuery
     */
    private function getDataProviderLastUpload(): ActiveQuery
    {
        return Yii::$app->user->getIdentity()
            ->documents()
            ->orderBy('id DESC');
    }

    /**
     * Запрос получения данных для дата провайдера последних добавленных
     *
     * @return ActiveQuery
     */
    private function getDataProviderPublic(): ActiveQuery
    {
        return Document::find()
            ->where(['is_public' => '1'])
            ->orderBy('id DESC');
    }

    /**
     * Запрос получения данных для дата провайдера последних добавленных
     *
     * @param integer $userId
     * @return ActiveQuery
     */
    private function getDataProviderCitizen(): ActiveQuery
    {
        return Document::find()
            ->where(['user_id' => UserService::getUserModel()->id])
            ->orWhere(['is_public' => '1'])
            ->orWhere(['is_private' => '0'])
            ->orderBy('id DESC');
    }

    /**
     * Запрос получения данных для дата провайдера последних добавленных
     *
     * @return ActiveQuery
     */
    private function getDataProviderElder(): ActiveQuery
    {
        return Document::find()
            ->orderBy('id DESC');
    }

    /**
     * Запрос получения данных для дата провайдера последних добавленных
     *
     * @return ActiveQuery
     */
    private function getDataProviderUsers(): ActiveQuery
    {
        return User::find()
            ->where(['!=', 'id' , UserService::getUserModel()->id])
            ->orderBy('id DESC');
    }
}