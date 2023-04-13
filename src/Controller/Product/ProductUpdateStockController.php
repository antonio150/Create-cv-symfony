<?php

namespace App\Controller\Product;

use App\Repository\ProductRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductUpdateStockController extends AbstractController
{
    /**
     * @Route("/api/v1/product/update/stock", name="app_product_update_stock")
     */
    public function updateStock(ProductRepository $productRepository): JsonResponse
    {
        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error'
            );
        } else {
            if (empty($data["id"])  || empty($data["quantity"]) ) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {

                try {
                    $product = $productRepository->find($data["id"]);
                    $stock = $product->getQantity();
                    $newStock = floatval($stock) +  floatval($data["quantity"]);
                    $productRepository->updateStock($data["id"], number_format($newStock, 2), true);
                    $output = array(
                        "status" => "success",
                        "message" => "Stock modifié avec succès !",
                        "nb" => $stock
                    );
                } catch (Exception $ex) {

                    $output = array(
                        "status" => "error",
                        "message" => $ex->getMessage()
                    );
                }
            }
        }
        return $this->json($output);
    }
}
