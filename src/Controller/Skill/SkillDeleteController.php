<?php

namespace App\Controller\Skill;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillDeleteController extends AbstractController
{
    /**
     * @Route("/skill/skill/delete", name="app_skill_skill_delete")
     */
    public function index(): Response
    {
        return $this->render('skill/skill_delete/index.html.twig', [
            'controller_name' => 'SkillDeleteController',
        ]);
    }
}
