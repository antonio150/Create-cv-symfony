<?php

namespace App\Controller\Basdepage;

use App\Entity\BasDePage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasdepageUpdateController extends AbstractController
{
    /**
     * @Route("/basdepage/basdepage/update", name="app_basdepage_basdepage_update")
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

            $date = date('Y-m-d');


            if (empty($parametersAsArray["id"])) {
                return $this->json([
                    'message' => 'Id Undefined !',
                    'status' => 'error'
                ]);
            } else {

                $basdepage = $entityManager->getRepository(BasDePage::class)->find($parametersAsArray["id"]);

                $basdepage->setDescription($parametersAsArray['description']);


                $basdepage->setDeleted(false);


                // $basdepage->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                $basdepage->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                $entityManager->flush();

                return $this->json([
                    'message' => 'Champ modifier',
                    'status' => 'succes'
                ]);
            }
        }
    }
}
