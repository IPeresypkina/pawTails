<?php


namespace app\models;
use yii\base\Model;
use yii\db\ActiveQuery;
use Yii;

class ProfileUpdateForm extends Model
{
    public $firstName;
    public $secondName;
    public $patronymic;
    public $email;
    public $phone;
    public $avatar;

    /**
     * @var User
     */
    private $_user;

    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['firstName', 'secondName', 'patronymic', 'phone', 'avatar'], 'trim'],
            [['firstName', 'secondName', 'patronymic', 'phone', 'avatar'], 'string', 'max' => 255],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => User::className(),
                'message' => Yii::t('app', 'ERROR_EMAIL_EXISTS'),
                'filter' => ['<>', 'id', $this->_user->id],
            ],
            ['email', 'string', 'max' => 255],
        ];
    }

    public function update()
    {

        if ($this->validate()) {
            $user = $this->_user;
            $user->firstName = $this->firstName;
            $user->secondName = $this->secondName;
            $user->patronymic = $this->patronymic;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->avatar = $this->avatar;
            return $user->save();
        } else {
            return false;
        }
    }
}