<?php

namespace App\Controller\Basdepage;

use App\Entity\BasDePage;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasdepageByIdController extends AbstractController
{
    /**
     * @Route("/basdepage/basdepage/by/id", name="app_basdepage_basdepage_by_id")
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
                'message' => 'Id Bas de page vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(BasDePage::class)->findBy(['id' => $parametersAsArray["id"]], ['deleted' => false]);

            if ($val === null) {
                return $this->json([
                    'message' => 'Id undefined',
                    'status' => 'success'
                ]);
            } else {
                $array = [];

                foreach ($val as $infos) {
                    $val["description"] = $infos->getDescription();

                    $val["createdAt"] = $infos->getCreatedAt();
                    $val["updatedAt"] = $infos->getUpdatedAt();


                    $array[] = $val;
                }




                return $this->json([
                    'message' => 'La liste des Bas de page',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}