<?php

namespace App\Controller\Skill;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillUpdateController extends AbstractController
{
    /**
     * @Route("/skill/skill/update", name="app_skill_skill_update")
     */
    public function index(): Response
    {
        return $this->render('skill/skill_update/index.html.twig', [
            'controller_name' => 'SkillUpdateController',
        ]);
    }
}
