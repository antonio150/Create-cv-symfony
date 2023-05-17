<?php

namespace App\Controller\Formation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationByIdController extends AbstractController
{
    /**
     * @Route("/formation/formation/by/id", name="app_formation_formation_by_id")
     */
    public function index(): Response
    {
        return $this->render('formation/formation_by_id/index.html.twig', [
            'controller_name' => 'FormationByIdController',
        ]);
    }
}
