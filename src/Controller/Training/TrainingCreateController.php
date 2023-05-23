<?php

namespace App\Controller\Training;

use App\Entity\ProfessionalTraining;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingCreateController extends AbstractController
{
    /**
     * @Route("/training/training/create", name="app_training_training_create")
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

                $formation = new ProfessionalTraining();

                $formation->setPosition($parametersAsArray['position']);
                $formation->setEmployer($parametersAsArray['employer']);
                $formation->setCity($parametersAsArray['city']);
                $formation->setMonthStart($parametersAsArray['month_start']);
                $formation->setYearStart($parametersAsArray['year_start']);
                $formation->setMonthEnd($parametersAsArray['month_end']);
                $formation->setYearEnd($parametersAsArray['year_end']);
                $formation->setThisDay($parametersAsArray['this_day']);
                $formation->setisDeleted(false);





                $formation->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                // $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


                $entityManager->persist($formation);
                $entityManager->flush();

                return $this->json([
                    'message' => 'Training créer avec succés',
                    'status' => 'success'
                ]);
            }
        }
    }
}