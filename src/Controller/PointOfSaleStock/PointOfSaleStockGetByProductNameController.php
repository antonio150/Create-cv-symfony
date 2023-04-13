<?php

namespace App\Controller\PointOfSaleStock;

use App\Entity\PointOfSale;
use App\Repository\PointOfSaleRepository;
use App\Repository\PointOfSaleStockRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PointOfSaleStockGetByProductNameController extends AbstractController
{
    /**
     * @Route("/api/v1/sale/stock/get/by/product/name", name="app_ppoint_of_sale_stock_get_by_product_name")
     */
    public function getStockPos(ProductRepository $productRepository, 
                                PointOfSaleStockRepository $pointOfSaleStockRepository,
                                PointOfSaleRepository $pointOfSaleRepository): JsonResponse
    {
        $output = array();
        $temp = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);


        $product = $productRepository->findBy(['name' => $data["name"]]);
        if (empty($product)) {
            $output = array(
                'message' => 'produit introuvable ! ',
                'status' => 'error'
            );
            return $this->json($output);
        }

        $pointOfSale = $pointOfSaleRepository->find($data["pointOfSale"]);
        if (empty($pointOfSale)) {
            $output = array(
                'message' => 'Point de vente introuvable ! ',
                'status' => 'error'
            );
            return $this->json($output);
        }

        $stockProduct = $pointOfSaleStockRepository->findBy(['point_of_sales' =>  $pointOfSale, 'product' => $product]);
        foreach ($stockProduct as $item) {
            $temp["id"] = $item->getId();
            $temp["name"] = $item->getProduct()->getName();
            $temp["price"] = $item->getProduct()->getPrice();
            $temp["stock"] = $item->getQuantity();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Info Produit du point de vente',
            'data' => $output,
            'status' => 'success'
        ]);
    
    }
}
