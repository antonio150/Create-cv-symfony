<?php

namespace App\Controller\Centerofinterest;

use App\Entity\CenterOfInterest;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterofinterestByIdController extends AbstractController
{
    /**
     * @Route("/centerofinterest/centerofinterest/by/id", name="app_centerofinterest_centerofinterest_by_id")
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
                'message' => 'Id centerofinterest vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(CenterOfInterest::class)->findBy(['id' => $parametersAsArray["id"], ['is_deleted' => false]]);

            if ($val === null) {
                return $this->json([
                    'message' => 'Id non definie',
                    'status' => 'success'
                ]);
            } else {
                $array = [];

                foreach ($val as $infos) {
                    $val["id_cv"] = $infos->getIdCv();
                    $val["description"] = $infos->getDescription();
                    $val["createdAt"] = $infos->getCreatedAt();
                    $val["updatedAt"] = $infos->getUpdatedAt();


                    $array[] = $val;
                }




                return $this->json([
                    'message' => 'Affichage de Center of Interest',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}