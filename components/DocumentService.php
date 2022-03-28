<?php

namespace app\components;

use Yii;
use yii\rbac\Role;
use app\models\Document;

class DocumentService 
{
    /**
     * @var string
     */
    public $statToDay;
    /**
     * @var string
     */
    public $statToWeek;
    
    /**
     * @var string
     */
    public $statToMonth;

    /**
     * @var string
     */
    public $ratioToDay;
    /**
     * @var string
     */
    public $ratioToWeek;

    /**
     * @var string
     */
    public $ratioToMonth;

    /**
     * Инициализация компонента
     *
     * @return void
     */
    public static function init() 
    {   
        $service = new self();
        $service->bindStat();
        $service->bindRatio(); 

        return $service;
    }

    /**
     * Установка параметров статистики
     *
     * @return void
     */
    public function bindStat(): void
    {
        $this->statToDay = $this->getTotalDocumentsCount(1);
        $this->statToWeek = $this->getTotalDocumentsCount(30);
        $this->statToMonth = $this->getTotalDocumentsCount(365);
    }

    /**
     * Установка параметров соотношения
     *
     * @return void
     */
    public function bindRatio(): void
    {
        $this->ratioToDay = $this->getRatioDocuments(1);
        $this->ratioToWeek = $this->getRatioDocuments(30);
        $this->ratioToMonth = $this->getRatioDocuments(365);
    }
    
    /**
     * Получение стат данных по кол-ву дней
     *
     * @param integer $days
     * @return void
     */
    public function getTotalDocumentsCount(int $days)
    {
       return (string) Document::find()->where('created_at >= DATE_SUB(CURRENT_DATE, INTERVAL ' . $days . ' DAY)')->count();
    }

    /**
     * Undocumented function
     *
     * @param integer $days
     * @param string $delimiter
     * @return string
     */
    public function getRatioDocuments(int $days, string $delimiter = '/'): string
    {
       return $this->getCountPublicDocs($days) . $delimiter . $this->getCountAuthDocs($days) . $delimiter . $this->getCountPrivateDocs($days);
    }

    /**
     * Получение данных по дням и публичных
     *
     * @param integer $days
     * @return integer
     */
    private function getCountPublicDocs(int $days): int
    {
        return Document::find()
            ->where(['is_public' => '1'])
            ->andWhere('created_at >= DATE_SUB(CURRENT_DATE, INTERVAL ' . $days . ' DAY)')->count();
    }

    /**
     * Получение данных по дням и условно публичных
     *
     * @param integer $days
     * @return integer
     */
    private function getCountAuthDocs(int $days): int
    {
        return Document::find()
            ->where(['is_public' => '0'])
            ->andWhere(['is_private' => '0'])
            ->andWhere('created_at >= DATE_SUB(CURRENT_DATE, INTERVAL ' . $days . ' DAY)')->count();
    }

    /**
     * Получение данных по дням и приватных
     *
     * @param integer $days
     * @return integer
     */
    private function getCountPrivateDocs(int $days): int
    {
        return Document::find()
            ->where(['is_private' => '1'])
            ->andWhere('created_at >= DATE_SUB(CURRENT_DATE, INTERVAL ' . $days . ' DAY)')->count();
    }
}