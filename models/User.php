<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $firstName Имя
 * @property string $secondName Фамилия
 * @property string|null $patronymic Отчество
 * @property string|null $avatar Аватар пользователя
 * @property string $phone Телефон
 * @property string $email Почта
 * @property string $createdAt Дата создания
 * @property string|null $updatedAt Дата изменения
 * @property string $accessToken Токен доступа
 * @property string $authKey Запомнить меня
 * @property integer $status Статус (активен/удален)
 * @property string $password_hash Хэш пароля
 * @property string $password write-only password
 *
 * @property Pet[] $pets
 */
class User extends BaseModel implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstName', 'phone', 'email'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['firstName', 'secondName', 'patronymic', 'avatar', 'phone', 'email', 'accessToken', 'authKey', 'password_hash'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstName' => 'Имя',
            'secondName' => 'Фамилия',
            'patronymic' => 'Отчество',
            'avatar' => 'Аватар пользователя',
            'phone' => 'Телефон',
            'email' => 'Почта',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата изменения',
            'accessToken' => 'Токен доступа',
            'authKey' => 'Запомнить меня',
            'status' => 'Статус (активен/удален)',
            'password_hash' => 'Хэш пароля',
        ];
    }

    /**
     * Gets query for [[Pets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPets()
    {
        return $this->hasMany(Pet::className(), ['userId' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     * @param $email
     * @return User|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    //------------Методы для востановления пароля---------------

    /**
     * @param $token
     * @return User|null
     */
    public static function findByPasswordResetToken($token)
    {

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'accessToken' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Проверка токена сброса пароля
     * @param $token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {

        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Удаление токена
     */
    public function removePasswordResetToken()
    {
        $this->accessToken = null;
    }
}
