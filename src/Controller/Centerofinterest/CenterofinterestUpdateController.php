<?php

namespace App\Controller\Centerofinterest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterofinterestUpdateController extends AbstractController
{
    /**
     * @Route("/centerofinterest/centerofinterest/update", name="app_centerofinterest_centerofinterest_update")
     */
    public function index(): Response
    {
        return $this->render('centerofinterest/centerofinterest_update/index.html.twig', [
            'controller_name' => 'CenterofinterestUpdateController',
        ]);
    }
}
