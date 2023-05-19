<?php

namespace App\Controller\Formation;

use App\Entity\Formation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationByIdController extends AbstractController
{
    /**
     * @Route("/formation/formation/by/id", name="app_formation_formation_by_id")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request

    ): Response
    {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        if (empty($parametersAsArray["id"])) {
            return $this->json([
                'message' => 'Id Formation vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(Formation::class)->findBy(['id' => $parametersAsArray["id"]]);

            if ($val === null) {
                return $this->json([
                    'message' => 'Id undefined',
                    'status' => 'success'
                ]);
            } else {
                $array = [];

                foreach ($val as $infos) {
                    $val["training"] = $infos->getTraining();
                    $val["establishment"] = $infos->getEstablishment();
                    $val["city"] = $infos->getCity();
                    $val["month_start"] = $infos->getMonthStart();
                    $val["year_start"] = $infos->getYearStart();
                    $val["month_end"] = $infos->getMonthEnd();
                    $val["year_end"] = $infos->getYearEnd();
                    $val["this_day"] = $infos->isThisDay();
                    $val["description"] = $infos->getDescription();


                    $array[] = $val;
                }

                return $this->json([
                    'message' => 'La liste des Information',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}