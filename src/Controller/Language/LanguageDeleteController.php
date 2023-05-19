<?php

namespace App\Controller\Language;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageDeleteController extends AbstractController
{
    /**
     * @Route("/language/language/delete", name="app_language_language_delete")
     */
    public function index(): Response
    {
        return $this->render('language/language_delete/index.html.twig', [
            'controller_name' => 'LanguageDeleteController',
        ]);
    }
}
