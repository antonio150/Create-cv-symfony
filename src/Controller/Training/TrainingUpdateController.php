<?php

namespace App\Controller\Training;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingUpdateController extends AbstractController
{
    /**
     * @Route("/training/training/update", name="app_training_training_update")
     */
    public function index(): Response
    {
        return $this->render('training/training_update/index.html.twig', [
            'controller_name' => 'TrainingUpdateController',
        ]);
    }
}
