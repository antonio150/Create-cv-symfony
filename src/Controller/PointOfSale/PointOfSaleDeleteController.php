<?php

namespace App\Controller\PointOfSale;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PointOfSaleDeleteController extends AbstractController
{
    /**
     * @Route("/point/of/sale/point/of/sale/delete", name="app_point_of_sale_point_of_sale_delete")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PointOfSale/PointOfSaleDeleteController.php',
        ]);
    }
}
