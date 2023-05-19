<?php

namespace App\Controller\Training;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingCreateController extends AbstractController
{
    /**
     * @Route("/training/training/create", name="app_training_training_create")
     */
    public function index(): Response
    {
        return $this->render('training/training_create/index.html.twig', [
            'controller_name' => 'TrainingCreateController',
        ]);
    }
}
