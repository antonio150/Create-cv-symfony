<?php

namespace App\Controller\Product;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductByIdController extends AbstractController
{
    /**
     * @Route("/api/v1/product/by/id", name="app_product_by_id")
     */
    public function getInfo(ProductRepository $productRepository): JsonResponse
    {
        $output = array();
        $temp = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        $product = $productRepository->findBy(['id' => $data["id"]]);
        
        if (empty($product)) {
            $output = array(
                'message' => 'Produit introuvable ! ',
                'status' => 'erreur'
            );
        } 

        foreach ($product as $item) {
            $temp["id"] = $item->getId();
            $temp["name"] = $item->getName();
            $temp["reference"] = $item->getReference();
            $temp["price"] = $item->getPrice();
            $temp["quantity"] = $item->getQantity();
            $temp["description"] = $item->getDescription();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Info Produit',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
