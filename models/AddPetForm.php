<?php


namespace app\models;


use yii\base\Model;

class AddPetForm extends Model
{
    public $userId;
    public $breedId;
    public $species;
    public $name;
    public $gender;
    public $photoId;
    public $specialSigns;
    public $status;

    /**
     * Signs user up.
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public function addPet()
    {
        $pet = new Pet();
        $pet->userId = $this->userId;
        $pet->breedId = $this->breedId;
        $pet->species = $this->species;
        $pet->name = $this->name;
        $pet->gender = $this->gender;
        $pet->photoId = $this->photoId;
        $pet->specialSigns = $this->specialSigns;
        $pet->status = $this->status;
        $pet->save();
        return $pet;
    }
}