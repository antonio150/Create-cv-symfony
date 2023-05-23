<?php

namespace App\Controller\Training;

use App\Entity\ProfessionalTraining;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingReadController extends AbstractController
{
    /**
     * @Route("/training/training/read", name="app_training_training_read")
     */
    public function index(): Response
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(ProfessionalTraining::class);
        $data = $repository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["position"] = $item->getPosition();
            $temp["employer"] = $item->getEmployer();
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

        return $this->json(['message' => 'Liste des Training',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}