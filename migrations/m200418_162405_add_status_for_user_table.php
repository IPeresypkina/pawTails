<?php

use yii\db\Migration;

/**
 * Class m200418_162405_add_status_for_user_table
 */
class m200418_162405_add_status_for_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'status', $this->smallInteger()->notNull()->defaultValue(10)->comment('Статус (активен/удален)'));
        $this->addColumn('{{%users}}', 'password_hash', $this->string()->notNull()->comment('Хэш'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'status');
        $this->dropColumn('{{%users}}', 'password_hash');
    }
}
