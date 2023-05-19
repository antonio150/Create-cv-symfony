<?php

namespace App\Controller\Skill;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillByIdController extends AbstractController
{
    /**
     * @Route("/skill/skill/by/id", name="app_skill_skill_by_id")
     */
    public function index(): Response
    {
        return $this->render('skill/skill_by_id/index.html.twig', [
            'controller_name' => 'SkillByIdController',
        ]);
    }
}
