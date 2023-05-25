<?php

namespace App\Controller\Centerofinterest;

use App\Entity\CenterOfInterest;
use App\Entity\Curriculum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterofinterestUpdateController extends AbstractController
{
    /**
     * @Route("/centerofinterest/centerofinterest/update", name="app_centerofinterest_centerofinterest_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): JsonResponse {
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

            foreach ($parametersAsArray as $centerofinterestJson) {

            $date = date('Y-m-d');


                if (empty($centerofinterestJson["id"])) {
                return $this->json(['message' => 'Id non definie !',
                    'status' => 'error'
                ]);
            } else {

                    $centerofinterest = $entityManager->getRepository(CenterOfInterest::class)->find($centerofinterestJson["id"]);
                    $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $centerofinterestJson["id_cv"]]);

                $array = [];


                $centerofinterest->setIdCv($val);

                    $centerofinterest->setDescription($centerofinterestJson['description']);


                $centerofinterest->setIsDeleted(false);


                // $centerofinterest->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $centerofinterestJson['createdAt']));
                $centerofinterest->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                $entityManager->flush();
                }
                return $this->json([
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                ]);
            }
        }
    }
}