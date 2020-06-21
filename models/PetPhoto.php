<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "petPhotos".
 *
 * @property int $id
 * @property string $photo Фотография
 * @property string $createdAt Дата создания
 * @property string|null $updatedAt Дата изменения
 * @property string|null $nosePhoto Фотка носа
 * @property string|null $facePhoto Фотка морды
 *
 * @property Pet[] $pets
 */
class PetPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'petPhotos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photo', 'createdAt'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['photo', 'nosePhoto', 'facePhoto'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'nosePhoto' => 'Nose Photo',
            'facePhoto' => 'Face Photo',
        ];
    }

    /**
     * Gets query for [[Pets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPets()
    {
        return $this->hasMany(Pet::className(), ['photoId' => 'id']);
    }

    /**
     * Возвращает список id фотографий потерянных питомцев породы $markBreed
     * @param $markBreed
     * @return string
     */
    public function getPhotoPetsByBreed($markBreed)
    {
        $breed = Breed::findOne(['mark' => $markBreed]);
        $pets = Pet::find()
            ->where(['breedId' => $breed->id])
            ->andWhere(['status' => 'lost'])
            ->all();
        $data ='';
        foreach ($pets as $pet)
        {
            $photo = PetPhoto::findOne(['id' => $pet->photoId]);
            $data .= $photo->id . ' ';

        }

        return $data;
    }
}
