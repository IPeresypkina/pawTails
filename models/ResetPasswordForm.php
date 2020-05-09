<?php


namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string токен сброса пароля
     */
    public $token;

    /**
     * @var string пароль
     */
    public $password;

    /**
     * @var string повторный пароль
     */
    public $passwordRepeat;

    /**
     * @var User пользователь
     */
    private $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['password', 'passwordRepeat'], 'required'],
            [['password', 'passwordRepeat'], 'string', 'max' => 255],
            ['passwordRepeat', 'validatePasswordRepeat']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль',
            'passwordRepeat' => 'Повторите пароль'
        ];
    }

    /**
     * Проверяет совподение паролей.
     * Если пароли не совподают, то добавляет ошибку в атрибут $attribute.
     *
     * @param string $attribute атрибут
     * @param array $params параметры
     */
    public function validatePasswordRepeat($attribute, $params)
    {
        if ($this->password !== $this->$attribute) {
            $this->addError($attribute, 'Пароли должны совпадать.');
        }
    }

    /**
     * Возвращает true, если пользователь действительно отправлял запрос на сброс пароля, иначе false.
     *
     * @return bool
     */
    public function verify()
    {
        $this->user = User::findOne(['accessToken' => $this->token]);
        return $this->user !== null;
    }

    /**
     * Устанавливает новый пароль для пользователя.
     * @throws \yii\base\Exception
     */
    public function complete()
    {
        $this->user->accessToken = null;
        $this->user->setPassword($this->password);
        $this->user->save(false);
    }
}