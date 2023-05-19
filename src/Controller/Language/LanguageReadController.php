<?php

namespace App\Controller\Language;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageReadController extends AbstractController
{
    /**
     * @Route("/language/language/read", name="app_language_language_read")
     */
    public function index(): Response
    {
        return $this->render('language/language_read/index.html.twig', [
            'controller_name' => 'LanguageReadController',
        ]);
    }
}
