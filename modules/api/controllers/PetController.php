<?php


namespace app\modules\api\controllers;


use app\models\AddPetForm;
use app\models\Pet;
use Yii;

class PetController extends BaseController
{
    /**
     * Создание питомца
     *
     * @return string
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $authKey = new Pet();
        $model = new AddPetForm();
        $model->load(Yii::$app->request->getBodyParams(), '');

        if ($model->validate()) {
            $pet = $model->addPet();
        }
        return $pet;
    }

    public function actionUpdate()
    {

    }

    public function actionDelete()
    {

    }
}