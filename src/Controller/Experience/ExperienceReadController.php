<?php

namespace App\Controller\Experience;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceReadController extends AbstractController
{
    /**
     * @Route("/experience/experience/read", name="app_experience_experience_read")
     */
    public function index(): Response
    {
        return $this->render('experience/experience_read/index.html.twig', [
            'controller_name' => 'ExperienceReadController',
        ]);
    }
}
