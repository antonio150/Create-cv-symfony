<?php

namespace App\Controller\Product;

use App\Repository\ProductRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductDeleteController extends AbstractController
{
    /**
     * @Route("/api/v1/product/delete", name="app_product_delete")
     */
    public function delete(ProductRepository $productRepository): JsonResponse
    {
        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        try {
            $productRepository->delete($data["id"], true);
            $output = array(
                "status" => "success",
                "message" => "Produit supprimé avec succès !"
            );
        } catch (Exception $ex) {

            $output = array(
                "status" => "erreur",
                "message" => $ex->getMessage()
            );
        }
        return $this->json($output);
    }
}
