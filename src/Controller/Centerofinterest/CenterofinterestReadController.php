<?php

namespace App\Controller\Centerofinterest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterofinterestReadController extends AbstractController
{
    /**
     * @Route("/centerofinterest/centerofinterest/read", name="app_centerofinterest_centerofinterest_read")
     */
    public function index(): Response
    {
        return $this->render('centerofinterest/centerofinterest_read/index.html.twig', [
            'controller_name' => 'CenterofinterestReadController',
        ]);
    }
}
