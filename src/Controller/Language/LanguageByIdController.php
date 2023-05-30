<?php

namespace App\Controller\Language;

use App\Entity\Language;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageByIdController extends AbstractController
{
    /**
     * @Route("/language/language/by/id", name="app_language_language_by_id")
     */
    public function index(
        Request $request,
        PersonalInformationRepository $info,
        EntityManagerInterface $entityManager
    ): Response {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        if (empty($parametersAsArray["id"])) {
            return $this->json([
                'message' => 'Id Information vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(Language::class)->findBy(['id' => $parametersAsArray["id"]], ['is_deleted' => false]);

            if ($val === null) {
                return $this->json(['message' => 'Id non definie',
                    'status' => 'error'
                ]);
            } else {
                $array = [];

                foreach ($val as $infos) {
                    $val["language"] = $infos->getLanguage();
                  
                    $val["createdAt"] = $infos->getCreatedAt();
                    $val["updatedAt"] = $infos->getUpdatedAt();


                    $array[] = $val;
                }




                return $this->json([
                    'message' => 'Affichage de language',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}