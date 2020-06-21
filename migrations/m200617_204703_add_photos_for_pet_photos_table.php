<?php

use yii\db\Migration;

/**
 * Class m200617_204703_add_photos_for_pet_photos_table
 */
class m200617_204703_add_photos_for_pet_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%petPhotos}}', 'nosePhoto', $this->string(255)->comment('Фотка носа'));
        $this->addColumn('{{%petPhotos}}', 'facePhoto', $this->string(255)->comment('Фотка морды'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%petPhotos}}', 'nosePhoto');
        $this->dropColumn('{{%petPhotos}}', 'facePhoto');
    }
}
