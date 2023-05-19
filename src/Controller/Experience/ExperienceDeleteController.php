<?php

namespace App\Controller\Experience;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceDeleteController extends AbstractController
{
    /**
     * @Route("/experience/experience/delete", name="app_experience_experience_delete")
     */
    public function index(): Response
    {
        return $this->render('experience/experience_delete/index.html.twig', [
            'controller_name' => 'ExperienceDeleteController',
        ]);
    }
}
