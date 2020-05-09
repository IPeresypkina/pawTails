<?php

/* @var $user \app\models\User */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['api/user/reset-password', 'token' => $user->accessToken]);
?>

    Hello <?= $user->firstName ?>,
    Follow the link below to reset your password:

<?= $resetLink ?>