<?php
namespace app\modules\api\controllers;

use app\models\forms\ResetForm;
use app\models\LoginForm;
use app\models\LoginupForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\User;
use Yii;
use app\models\SignupForm;
use app\modules\api\controllers\BaseController;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends BaseController
{
    public function verbs()
    {
        return [
            'signup' => ['POST', 'OPTIONS'],
            'request-password-reset' => ['POST', 'OPTIONS'],
            'reset-password' => ['POST', 'OPTIONS'],
            'loginup' => ['POST', 'OPTIONS'],
            'logout' => ['POST', 'OPTIONS'],
            'view' => ['GET', 'OPTIONS'],
        ];
    }

    /**
     * Регистрация пользователя
     *
     * @return string
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSignup()
    {
        $authKey = new User();
        $model = new SignupForm();
        $model->load(Yii::$app->request->getBodyParams(), '');

        if ($model->validate()) {
            $authKey->authKey = $model->signup();
        }
        return $authKey;
    }

    /**
     * Login action.
     * @return LoginForm|array|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLoginup()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->login()) {
            return $model;
        }

        return $model;
    }

    /**
     * Logout action.
     * @return array|Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Запрос сброса пароля
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $model;
    }

    /**
     * Сбрасывание пароля
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword($token)
    {
        $model = new ResetPasswordForm(['token' => $token]);

        if (!$model->verify()) {
            throw new NotFoundHttpException('Страница не найдена.');
        }
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->validate()) {
            $model->complete();
            Yii::$app->session->setFlash('success', 'New password was saved.');
        }

        return $model;
    }

    /**
     * Получение пользователя по id
     * @param $id
     * @return User|null
     */
    public function actionView($id)
    {
        $user = User::findOne($id);
        return $user;
    }

    /**
     * Обновление данных пользователя по id
     * @param $id
     * @return User|null
     */
    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        return $user;
    }
}