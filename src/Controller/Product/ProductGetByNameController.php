<?php

namespace App\Controller\Product;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductGetByNameController extends AbstractController
{
    /**
     * @Route("/api/v1/product/get/by/name", name="app_product_get_by_name")
     */
    public function getByNameProduct(ProductRepository $productRepository): JsonResponse
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


        foreach ($product as $item) {
            $temp["id"] = $item->getId();
            $temp["name"] = $item->getName();
            $temp["price"] = $item->getPrice();
            $temp["stock"] = $item->getQantity();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Info Produit',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
