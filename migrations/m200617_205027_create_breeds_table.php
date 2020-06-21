<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%breeds}}`.
 */
class m200617_205027_create_breeds_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%breeds}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название породы'),
            'mark' => $this->integer(11)->notNull()->comment('Метка породы'),
            'createdAt' => $this->dateTime()->notNull()->comment('Дата создания'),
            'updatedAt' => $this->dateTime()->comment('Дата изменения')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%breeds}}');
    }
}
