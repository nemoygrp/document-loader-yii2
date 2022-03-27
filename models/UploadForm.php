<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class UploadForm extends Model
{
    private $model;
    public $document;
    public $public = false;
    public $private = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],

            ['public', 'boolean'],

            ['private', 'boolean'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function handle(): void
    {
        if (! $this->validate()) {
            return;
        }

        $this->signHistory();
    }


    /**
     * Метод загружающий файл
     *
     * @return void
     */
    private function uploadFile(): void
    {
        $this->document->saveAs('@storage/' . $this->model->getCryptFilename());
    }

    /**
     * Метод записывающий данные о 
     *
     * @return void
     */
    private function signHistory(): void 
    {
        $this->model = new Document();
        $this->model->user_id = Yii::$app->user->getId();
        $this->model->name = $this->document->baseName;
        $this->model->extension = $this->document->extension;
        $this->model->size = $this->document->size;
        $this->model->is_private = $this->private;
        $this->model->is_public = $this->public;
        $this->model->save(false);

        $this->uploadFile();
    }

}
