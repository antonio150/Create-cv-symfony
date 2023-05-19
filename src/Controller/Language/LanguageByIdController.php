<?php

namespace App\Controller\Language;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageByIdController extends AbstractController
{
    /**
     * @Route("/language/language/by/id", name="app_language_language_by_id")
     */
    public function index(): Response
    {
        return $this->render('language/language_by_id/index.html.twig', [
            'controller_name' => 'LanguageByIdController',
        ]);
    }
}
