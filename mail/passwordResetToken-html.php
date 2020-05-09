<?php

use yii\helpers\Html;

/* @var $user \app\models\User */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['api/user/reset-password', 'token' => $user->accessToken]);
?>

<div class="password-reset">
    <p>Hello <?= Html::encode($user->firstName) ?>,</p>
    <p>Follow the link below to reset your password:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>