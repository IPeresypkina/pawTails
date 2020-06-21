<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pets".
 *
 * @property int $id
 * @property int $userId FK Пользователя
 * @property int $breedId FK Породы
 * @property string $species Вид
 * @property string|null $name Кличка
 * @property string|null $gender м/ж
 * @property int $photoId FK Фотографий
 * @property string|null $specialSigns Особые приметы
 * @property string $status Статус (найден/потерян/none)
 * @property string $createdAt Дата создания
 * @property string|null $updatedAt Дата изменения
 *
 * @property User $user
 * @property PetPhoto $photo
 * @property Breed $breed
 */
class Pet extends \yii\db\ActiveRecord
{

    const STATUS_FIND = 'find';
    const STATUS_LOST = 'lost';
    const STATUS_NONE = 'none';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'breedId', 'photoId', 'status', 'createdAt'], 'required'],
            [['userId', 'breedId', 'photoId'], 'integer'],
            [['species', 'gender', 'specialSigns'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['status'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['photoId'], 'exist', 'skipOnError' => true, 'targetClass' => PetPhoto::className(), 'targetAttribute' => ['photoId' => 'id']],
            [['breedId'], 'exist', 'skipOnError' => true, 'targetClass' => Breed::className(), 'targetAttribute' => ['breedId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'breedId' => 'Breed ID',
            'species' => 'Species',
            'name' => 'Name',
            'gender' => 'Gender',
            'photoId' => 'Photo ID',
            'specialSigns' => 'Special Signs',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * Gets query for [[Photo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhoto()
    {
        return $this->hasOne(PetPhoto::className(), ['id' => 'photoId']);
    }

    /**
     * Gets query for [[Breed]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBreed()
    {
        return $this->hasOne(Breed::className(), ['id' => 'breedId']);
    }
}
