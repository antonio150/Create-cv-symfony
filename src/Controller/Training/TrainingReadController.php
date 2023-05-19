<?php

namespace App\Controller\Training;

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
        return $this->render('training/training_read/index.html.twig', [
            'controller_name' => 'TrainingReadController',
        ]);
    }
}
