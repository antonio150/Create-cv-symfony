<?php

namespace App\Controller\Skill;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillReadController extends AbstractController
{
    /**
     * @Route("/skill/skill/read", name="app_skill_skill_read")
     */
    public function index(): Response
    {
        return $this->render('skill/skill_read/index.html.twig', [
            'controller_name' => 'SkillReadController',
        ]);
    }
}
