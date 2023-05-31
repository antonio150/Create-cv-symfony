<?php

namespace App\Controller\Formation;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationReadController extends AbstractController
{
    /**
     * @Route("/formation/formation/read", name="app_formation_formation_read")
     */
    public function readFormation(Request $request): Response
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(Formation::class);
        $data = $repository->findBy(['deleted' => false], array('id' => 'DESC'));

       

        foreach ($data as $item) {
            $temp["id_cv"] = $item->getIdCv();
            $temp["training"] = $item->getTraining();
            $temp["establishment"] = $item->getEstablishment();
            $temp["city"] = $item->getCity();
            $temp["month_start"] = $item->getMonthStart();
            $temp["year_start"] = $item->getYearStart();
            $temp["month_end"] = $item->getMonthEnd();
            $temp["year_end"] = $item->getYearEnd();
            $temp["this_day"] = $item->isThisDay();
            $temp["description"] = $item->getDescription();

            $temp["createdAt"] = $item->getCreatedAt();
            $temp["updatedAt"] = $item->getUpdatedAt();
            array_push($output, $temp);
        }

        return $this->json(['Formation' => $output
        ]);
    }
}