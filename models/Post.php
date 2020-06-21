<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $userId FK Users
 * @property int $petId FK Pets
 * @property string|null $content Описание
 * @property int $location Место положение
 * @property string $date Дата потери/находки
 * @property string $createdAt Дата создания
 * @property string $updatedAt Дата изменения
 *
 * @property User $user
 * @property Pet $pet
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'petId', 'location', 'date', 'createdAt', 'updatedAt'], 'required'],
            [['userId', 'petId', 'location'], 'integer'],
            [['date', 'createdAt', 'updatedAt'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['petId'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::className(), 'targetAttribute' => ['petId' => 'id']],
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
            'petId' => 'Pet ID',
            'content' => 'Content',
            'location' => 'Location',
            'date' => 'Date',
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
     * Gets query for [[Pet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPet()
    {
        return $this->hasOne(Pet::className(), ['id' => 'petId']);
    }

    /**
     * Получить посты потерявшихся питомцев
     * @param $id
     * @return array
     */
    public function getPetPost($id)
    {
        $arrIds = str_split($id);
        $posts = [];
        foreach ($arrIds as $id)
        {
            if ($id != " "){
                $pet = Pet::findOne(['photoId' => $id]);
                $posts[] .= Post::findOne(['petId' => $pet->id]);
            }
        }
        return $posts;
    }

    public function getFilterPost($id)
    {

    }
}
