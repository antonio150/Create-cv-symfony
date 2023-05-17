<?php

namespace App\Controller\Formation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationUpdateController extends AbstractController
{
    /**
     * @Route("/formation/formation/update", name="app_formation_formation_update")
     */
    public function index(): Response
    {
        return $this->render('formation/formation_update/index.html.twig', [
            'controller_name' => 'FormationUpdateController',
        ]);
    }
}
