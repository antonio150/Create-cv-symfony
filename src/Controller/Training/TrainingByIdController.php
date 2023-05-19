<?php

namespace App\Controller\Training;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingByIdController extends AbstractController
{
    /**
     * @Route("/training/training/by/id", name="app_training_training_by_id")
     */
    public function index(): Response
    {
        return $this->render('training/training_by_id/index.html.twig', [
            'controller_name' => 'TrainingByIdController',
        ]);
    }
}
