<?php

namespace App\Controller\PointOfSaleStock;

use App\Repository\PointOfSaleRepository;
use App\Repository\PointOfSaleStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PointOfSaleStockListController extends AbstractController
{
    /**
     * @Route("/api/v1/point/of/sale/stock/list", name="app_point_of_sale_stock_list")
     */
    public function list(PointOfSaleStockRepository $pointOfSaleStockRepository, PointOfSaleRepository $pointOfSaleRepository): JsonResponse
    {
        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            $stock = $pointOfSaleStockRepository->findAll(array('id' => 'DESC'));
        } else {
            $pointOfSaleID = $data["pointOfSale"];
            $pointOfSale = $pointOfSaleRepository->find($pointOfSaleID);
            $stock = $pointOfSaleStockRepository->findBy(['point_of_sales' => $pointOfSale], array('id' => 'DESC'));
        }

        foreach ($stock as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["product"] = $item->getProduct()->getName();
            $temp["pointOfSale"] = $item->getPointOfSales()->getName();
            $temp["quantity"] = $item->getQuantity();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des stocks par point de vente',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
