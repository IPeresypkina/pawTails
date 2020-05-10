<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pets".
 *
 * @property int $id
 * @property int $userId FK Пользователя
 * @property string $species Вид
 * @property string|null $name Кличка
 * @property string|null $gender м/ж
 * @property string $breed Порода
 * @property int $photoId FK Фотографий
 * @property string|null $specialSigns Особые приметы
 * @property string $status Статус (найден/потерян/none)
 * @property string $createdAt Дата создания
 * @property string|null $updatedAt Дата изменения
 *
 * @property User $user
 * @property PetPhoto $photo
 */
class Pet extends BaseModel
{
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
            [['userId', 'breed', 'photoId', 'createdAt'], 'required'],
            [['userId', 'photoId'], 'integer'],
            [['species', 'gender', 'specialSigns'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name', 'breed'], 'string', 'max' => 128],
            [['status'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['photoId'], 'exist', 'skipOnError' => true, 'targetClass' => PetPhoto::className(), 'targetAttribute' => ['photoId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'FK Пользователя',
            'species' => 'Вид',
            'name' => 'Кличка',
            'gender' => 'м/ж',
            'breed' => 'Порода',
            'photoId' => 'FK Фотографий',
            'specialSigns' => 'Особые приметы',
            'status' => 'Статус (найден/потерян/none)',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата изменения',
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
}
