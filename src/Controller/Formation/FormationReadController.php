<?php

namespace App\Controller\Formation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationReadController extends AbstractController
{
    /**
     * @Route("/formation/formation/read", name="app_formation_formation_read")
     */
    public function index(): Response
    {
        return $this->render('formation/formation_read/index.html.twig', [
            'controller_name' => 'FormationReadController',
        ]);
    }
}
