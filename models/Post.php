<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $userId FK Users
 * @property string|null $content Описание
 * @property int $location Место положение
 * @property string $date Дата потери/находки
 * @property string $createdAt Дата создания
 * @property string $updatedAt Дата изменения
 *
 * @property User $user
 */
class Post extends BaseModel
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
            [['userId', 'location', 'date', 'createdAt', 'updatedAt'], 'required'],
            [['userId', 'location'], 'integer'],
            [['date', 'createdAt', 'updatedAt'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'FK Users',
            'content' => 'Описание',
            'location' => 'Место положение',
            'date' => 'Дата потери/находки',
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
}
