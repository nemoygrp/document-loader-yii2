<?php

use yii\db\Migration;
use app\models\Document;
use app\models\User;

class m220326_143944_create_documents_table extends Migration
{
    protected function getMainTableName(): string
    {
        return Document::tableName();
    }

    public function up()
    {
        $this->createTable($this->getMainTableName(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'extension' => $this->string(10)->notNull(),
            'size' => $this->integer()->notNull(),
            'is_private' => $this->tinyInteger()->notNull()->defaultValue(1),
            'is_public' => $this->tinyInteger()->notNull()->defaultValue(0),
            
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex('idx-documents-user_id', $this->getMainTableName(), 'user_id');

        $this->addForeignKey ('user_id', $this->getMainTableName(), 'user_id', User::tableName(), 'id');
    }
    public function down()
    {
        $this->dropTable($this->getMainTableName());
    }
}