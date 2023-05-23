<?php

namespace App\Controller\Training;

use App\Entity\ProfessionalTraining;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingByIdController extends AbstractController
{
    /**
     * @Route("/training/training/by/id", name="app_training_training_by_id")
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
                'message' => 'Id Training vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(ProfessionalTraining::class)->findBy(['id' => $parametersAsArray["id"]], ['is_deleted' => false]);

            if ($val === null) {
                return $this->json([
                    'message' => 'Id non definie',
                    'status' => 'error'
                ]);
            } else {
                $array = [];

                foreach ($val as $training) {
                    $val["position"] = $training->getPosition();
                    $val["employer"] = $training->getEmployer();
                    $val["city"] = $training->getCity();
                    $val["month_start"] = $training->getMonthStart();
                    $val["year_start"] = $training->getYearStart();
                    $val["month_end"] = $training->getMonthEnd();
                    $val["year_end"] = $training->getYearEnd();
                    $val["this_day"] = $training->isThisDay();
                    $val["description"] = $training->getDescription();


                    $array[] = $val;
                }

                return $this->json([
                    'message' => 'Liste des training',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}