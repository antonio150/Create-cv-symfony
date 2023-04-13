<?php

namespace App\Controller\Product;

use App\Repository\PointOfSaleRepository;
use App\Repository\PointOfSaleStockRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductListController extends AbstractController
{
    /**
     * @Route("/api/v1/product/list", name="app_product_list")
     */
    public function list(ProductRepository $productRepository, PointOfSaleStockRepository $pointOfSaleStockRepository, PointOfSaleRepository $pointOfSaleRepository): JsonResponse
    {
        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

         if (empty($data)) {
            $product = $productRepository->findBy(['is_deleted' => false], array('id' => 'DESC'));
            foreach ($product as $item) {
                $temp = array();
                $temp["id"] = $item->getId();
                $temp["name"] = $item->getName();
                $temp["description"] = $item->getDescription();
                $temp["price"] = $item->getPrice();
                $temp["quantity"] = $item->getQantity();
                $temp["reference"] = $item->getReference();
                $temp["createdAt"] = $item->getCreatedAt();
                $temp["is_deleted"] = $item->isIsDeleted();
                array_push($output, $temp);
            }
        }
        else {
            $pointOfSaleID = $data["pointOfSaleID"];
            $pointOfSale = $pointOfSaleRepository->find($pointOfSaleID);
            $product = $pointOfSaleStockRepository->findBy(['point_of_sales' => $pointOfSale], array('id' => 'DESC'));
            foreach ($product as $item) {
                $temp = array();
                $temp["id"] = $item->getId();
                $temp["name"] = $item->getProduct()->getName();
                $temp["description"] = $item->getProduct()->getDescription();
                $temp["price"] = $item->getProduct()->getPrice();
                $temp["quantity"] = $item->getQuantity();
                $temp["reference"] = $item->getProduct()->getReference();
                $temp["createdAt"] =$item->getProduct()->getCreatedAt();
                $temp["is_deleted"] = $item->getProduct()->isIsDeleted();
                array_push($output, $temp);
            }
        }
       // $product = $productRepository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        // foreach ($product as $item) {
        //     $temp = array();
        //     $temp["id"] = $item->getId();
        //     $temp["name"] = $item->getName();
        //     $temp["description"] = $item->getDescription();
        //     $temp["price"] = $item->getPrice();
        //     $temp["quantity"] = $item->getQantity();
        //     $temp["reference"] = $item->getReference();
        //     $temp["createdAt"] = $item->getCreatedAt();
        //     $temp["is_deleted"] = $item->isIsDeleted();
        //     array_push($output, $temp);
        // }

        return $this->json([
            'message' => 'La liste des produits',
            'data' => $output,
            'status' => 'success'
        ]);

    }
}
