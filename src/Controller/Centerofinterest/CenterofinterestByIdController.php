<?php

namespace App\Controller\Centerofinterest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterofinterestByIdController extends AbstractController
{
    /**
     * @Route("/centerofinterest/centerofinterest/by/id", name="app_centerofinterest_centerofinterest_by_id")
     */
    public function index(): Response
    {
        return $this->render('centerofinterest/centerofinterest_by_id/index.html.twig', [
            'controller_name' => 'CenterofinterestByIdController',
        ]);
    }
}
