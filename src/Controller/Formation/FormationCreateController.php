<?php

namespace App\Controller\Formation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationCreateController extends AbstractController
{
    /**
     * @Route("/formation/formation/create", name="app_formation_formation_create")
     */
    public function index(): Response
    {
        return $this->render('formation/formation_create/index.html.twig', [
            'controller_name' => 'FormationCreateController',
        ]);
    }
}
