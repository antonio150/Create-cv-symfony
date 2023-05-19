<?php

namespace App\Controller\Centerofinterest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterofinterestDeleteController extends AbstractController
{
    /**
     * @Route("/centerofinterest/centerofinterest/delete", name="app_centerofinterest_centerofinterest_delete")
     */
    public function index(): Response
    {
        return $this->render('centerofinterest/centerofinterest_delete/index.html.twig', [
            'controller_name' => 'CenterofinterestDeleteController',
        ]);
    }
}
