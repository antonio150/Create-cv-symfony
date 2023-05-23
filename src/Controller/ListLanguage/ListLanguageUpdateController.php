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

        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {
            if (
                empty($parametersAsArray['note_language']) || empty($parametersAsArray['id_language'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {


                $date = date('Y-m-d');



                if (empty($parametersAsArray["id"])) {
                    return $this->json(['message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
                } else {
                    $formation = $entityManager->getRepository(ListLanguage::class)->findOneBy(["id" => $parametersAsArray["id"]]);


                    $val = $entityManager->getRepository(Language::class)->findOneBy(['id' => $parametersAsArray["id_language"]]);

                    $array = [];


                    $formation->setIdLanguage($val);

                    $id_cv = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $parametersAsArray["id_cv"]]);

                    $array = [];


                    $formation->setIdCv($id_cv);



                    $formation->setNoteLanguage($parametersAsArray['note_language']);


                    $formation->setDeleted(false);



                    // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                    $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    return $this->json(['message' => 'Modification effectué avec succès',
                        'status' => 'success'
                    ]);
                }
            }
        }
    }
}