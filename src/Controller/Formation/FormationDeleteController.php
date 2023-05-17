<?php

namespace App\Controller\Formation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationDeleteController extends AbstractController
{
    /**
     * @Route("/formation/formation/delete", name="app_formation_formation_delete")
     */
    public function index(): Response
    {
        return $this->render('formation/formation_delete/index.html.twig', [
            'controller_name' => 'FormationDeleteController',
        ]);
    }
}
