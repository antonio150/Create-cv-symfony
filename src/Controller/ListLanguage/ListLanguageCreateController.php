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

class ListLanguageCreateController extends AbstractController
{
    /**
     * @Route("/list/language/list/language/create", name="app_list_language_list_language_create")
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

                $formation = new ListLanguage();

                $val = $entityManager->getRepository(Language::class)->findBy(['id' => $parametersAsArray["id_language"]]);

                $array = [];

                foreach ($val as $infos) {
                    $formation->setIdLanguage($infos);


                    $array[] = $formation;
                }


                $id_cv = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $parametersAsArray["id_cv"]]);

                $array = [];

                foreach ($id_cv as $infos) {
                    $formation->setIdCv($infos);


                    $array[] = $formation;
                }
                $formation->setNoteLanguage($parametersAsArray['note_language']);


                $formation->setDeleted(false);





                $formation->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                // $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


                $entityManager->persist($formation);
                $entityManager->flush();

                return $this->json([
                    'message' => 'Formation Créer',
                    'status' => 'success'
                ]);
            }
        }
    }
}