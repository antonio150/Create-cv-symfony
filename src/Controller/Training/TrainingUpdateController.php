<?php

namespace App\Controller\Training;

use App\Entity\ProfessionalTraining;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingUpdateController extends AbstractController
{
    /**
     * @Route("/training/training/update", name="app_training_training_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
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
                empty($parametersAsArray['position']) || empty($parametersAsArray['employer']) || empty($parametersAsArray['city']) ||
                empty($parametersAsArray['month_start']) || empty($parametersAsArray['year_start']) || empty($parametersAsArray['month_end']) || empty($parametersAsArray['year_end'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
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
                    $training = $entityManager->getRepository(ProfessionalTraining::class)->find($parametersAsArray["id"]);


                    $training->setPosition($parametersAsArray['position']);
                    $training->setEmployer($parametersAsArray['employer']);
                    $training->setCity($parametersAsArray['city']);
                    $training->setMonthStart($parametersAsArray['month_start']);
                    $training->setYearStart($parametersAsArray['year_start']);
                    $training->setMonthEnd($parametersAsArray['month_end']);
                    $training->setYearEnd($parametersAsArray['year_end']);
                    $training->setThisDay($parametersAsArray['this_day']);

                    $training->setIsDeleted(false);



                    // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                    $training->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    return $this->json([
                        'message' => 'Champ modifier',
                        'status' => 'succes'
                    ]);
                }
            }
        }
    }
}