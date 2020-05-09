<?php

use yii\db\Migration;

/**
 * Class m200412_164037_add_token_and_key_for_users_table
 */
class m200412_164037_add_token_and_key_for_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'accessToken', $this->string(255)->notNull()->comment('Токен доступа'));
        $this->addColumn('{{%users}}', 'authKey',  $this->string(255)->notNull()->comment('Запомнить меня'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'accessToken');
        $this->dropColumn('{{%users}}', 'authKey');
    }
}
