<?php

namespace App\Controller\Training;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingDeleteController extends AbstractController
{
    /**
     * @Route("/training/training/delete", name="app_training_training_delete")
     */
    public function index(): Response
    {
        return $this->render('training/training_delete/index.html.twig', [
            'controller_name' => 'TrainingDeleteController',
        ]);
    }
}
