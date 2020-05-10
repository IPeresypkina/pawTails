<?php


namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $firstName;
    public $email;
    public $phone;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['firstName', 'trim'],
            ['firstName', 'required'],
            ['firstName', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['phone', 'required'],
            ['phone', 'string'],
            ['password', 'required'],
            ['password', 'string'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        var_dump($this->firstName); die;
        $user = new User();
        $user->firstName = $this->firstName;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();
        return $user->authKey;
    }

}