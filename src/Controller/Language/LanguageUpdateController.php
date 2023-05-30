<?php

namespace App\Controller\Language;

use App\Entity\Language;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageUpdateController extends AbstractController
{
    /**
     * @Route("/language/language/update", name="app_language_language_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): JsonResponse {
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
                empty($parametersAsArray['language']) || empty($parametersAsArray['level'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {


                $date = date('Y-m-d');


                if (empty($parametersAsArray["id"])) {
                    return $this->json([
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
                } else {

                    $lang = $entityManager->getRepository(Language::class)->find($parametersAsArray["id"]);

                    $lang->setLanguage($parametersAsArray['language']);
                   
                    $lang->setIsDeleted(false);


                    // $lang->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                    $lang->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    return $this->json([
                        'message' => 'Modification effectué avec succès',
                        'status' => 'success'
                    ]);
                }
            }
        }
    }
}