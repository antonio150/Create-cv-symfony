<?php

namespace App\Controller\Language;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageUpdateController extends AbstractController
{
    /**
     * @Route("/language/language/update", name="app_language_language_update")
     */
    public function index(): Response
    {
        return $this->render('language/language_update/index.html.twig', [
            'controller_name' => 'LanguageUpdateController',
        ]);
    }
}
