<?php


namespace app\modules\api\controllers;


use app\models\Pet;
use app\models\PetPhoto;
use app\models\Post;
use RecursiveIteratorIterator;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;


class PostController extends BaseController
{
    public function verbs()
    {
        return [
            'pet-identity' => ['GET', 'OPTIONS'],
        ];
    }

    public function actionPetIdentity()
    {
        $pathImageDataset = '';
        $datasetPath = '/Users/irinaperesypkina/PhpstormProjects/pawTails/dataset';
        $fileinfos = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($datasetPath)
        );
        foreach($fileinfos as $pathname => $fileinfo) {
            if (!$fileinfo->isFile()) continue;
            $pathImageDataset .= $pathname . ' ';
        }

        $pathDetectBreed = "/Users/irinaperesypkina/PycharmProjects/petsDetect/TestDetect/PetsDetect.py";
        $command = escapeshellcmd($pathDetectBreed . ' ' . $pathImageDataset);
        $mark = shell_exec($command);

        $pets = new PetPhoto();
        $listPhotos = $pets->getPhotoPetsByBreed($mark);

        $pathIdentityPet = "/Users/irinaperesypkina/PycharmProjects/petsDetect/TestDetect/PetsIdentity.py";

        $command = escapeshellcmd($pathIdentityPet . ' ' . $listPhotos);
        $idPetPhotos = shell_exec($command);

        $idPetPhotos = "1 3";
        $post = new Post();
        $listPost = $post->getPetPost($idPetPhotos);

        return $listPost;
    }

    public function actionCreate()
    {

    }

    public function actionView($id)
    {

    }

    public function actionUpdate($id)
    {

    }

    public function actionDelete($id)
    {

    }


}