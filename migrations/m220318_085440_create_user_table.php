<?php

use yii\db\Migration;
use app\models\User;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m220318_085440_create_user_table extends Migration
{
    protected function getMainTableName(): string
    {
        return User::tableName();
    }

    public function up()
    {
        $this->createTable($this->getMainTableName(), [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex('idx-user-username', $this->getMainTableName(), 'username', true);
        $this->createIndex('idx-user-email', $this->getMainTableName(), 'email', true);
    }
    public function down()
    {
        $this->dropTable($this->getMainTableName());
    }
}
