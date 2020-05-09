<?php

use yii\helpers\Html;

/* @var $model \app\models\User */

//$link = Yii::$app->urlManager->createAbsoluteUrl(['site/reset', 'token' => $model->accessToken]);
?>

<h1>Смена пароля</h1>

<p>
    Был получен запрос на смену пароля вашего аккаунта <?= $model->email ?>.
</p>
<p>
    Чтобы поставить новый пароль, перейдите по ссылке:<br>
<!--    --><?//= Html::a($link, $link) ?>
<p>
    Если запрос на смену пароля вы не отправляли, можете удалить это письмо.
</p>