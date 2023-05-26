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

                    $listlanguage = new ListLanguage();

                    $val = $entityManager->getRepository(Language::class)->findBy(['id' => $listlanguageJson["id_language"]]);

                $array = [];

                foreach ($val as $infos) {
                        $listlanguage->setIdLanguage($infos);
                    }
                    $id_cv = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $listlanguageJson["id_cv"]]);

                $array = [];

                foreach ($id_cv as $infos) {
                        $listlanguage->setIdCv($infos);


                }
                    $listlanguage->setNoteLanguage($listlanguageJson['note_language']);


                    $listlanguage->setDeleted(false);

                    $listlanguage->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $listlanguage->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $listlanguageJson['updatedAt']));


                    $entityManager->persist($listlanguage);
                $entityManager->flush();
                }
            }
            return $this->json([
                'message' => 'Formation créer avec succés',
                'status' => 'success'
            ]);
        }
    }
}