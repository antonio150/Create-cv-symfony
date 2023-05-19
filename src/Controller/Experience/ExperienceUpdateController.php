<?php

namespace App\Controller\Experience;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceUpdateController extends AbstractController
{
    /**
     * @Route("/experience/experience/update", name="app_experience_experience_update")
     */
    public function index(): Response
    {
        return $this->render('experience/experience_update/index.html.twig', [
            'controller_name' => 'ExperienceUpdateController',
        ]);
    }
}
