<?php

namespace App\Controller\ListLanguage;

use App\Entity\Curriculum;
use App\Entity\Language;
use App\Entity\ListLanguage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListLanguageUpdateController extends AbstractController
{
    /**
     * @Route("/list/language/list/language/update", name="app_list_language_list_language_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $countNB = count($parametersAsArray);


        if ($countNB === 0) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            foreach ($parametersAsArray as $listlanguageJson) {
            if (
                    empty($listlanguageJson['note_language']) || empty($listlanguageJson['id_language'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {


                $date = date('Y-m-d');



                    if (empty($listlanguageJson["id"])) {
                    return $this->json(['message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
                } else {
                        $formation = $entityManager->getRepository(ListLanguage::class)->findOneBy(["id" => $listlanguageJson["id"]]);


                        $val = $entityManager->getRepository(Language::class)->findOneBy(['id' => $listlanguageJson["id_language"]]);

                    $array = [];


                    $formation->setIdLanguage($val);

                        $id_cv = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $listlanguageJson["id_cv"]]);

                    $array = [];


                    $formation->setIdCv($id_cv);



                        $formation->setNoteLanguage($listlanguageJson['note_language']);


                    $formation->setDeleted(false);



                    // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $listlanguageJson['createdAt']));
                    $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();
                    }
                }
            }
            return $this->json([
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            ]);
        }
    }
}