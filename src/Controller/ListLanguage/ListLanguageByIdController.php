<?php

namespace App\Controller\ListLanguage;

use App\Entity\ListLanguage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListLanguageByIdController extends AbstractController
{
    /**
     * @Route("/list/language/list/language/by/id", name="app_list_language_list_language_by_id")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request

    ): Response {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        if (empty($parametersAsArray["id"])) {
            return $this->json([
                'message' => 'Id ListLanguage vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(ListLanguage::class)->findBy(['id' => $parametersAsArray["id"]], ['deleted' => false]);

            if ($val === null) {
                return $this->json([
                    'message' => 'Id undefined',
                    'status' => 'success'
                ]);
            } else {
                $array = [];

                foreach ($val as $infos) {
                    $val["id_cv"] = $infos->getIdCv();
                    $val["id_language"] = $infos->getIdLanguage();
                    $val["note_language"] = $infos->getNoteLanguage();



                    $array[] = $val;
                }

                return $this->json(['message' => 'Liste des Listlanguage',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}