<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductEditController extends AbstractController
{
    /**
     * @Route("/api/v1/product/edit", name="app_product_edit")
     */
    public function edit(ProductRepository $productRepository): JsonResponse
    {
        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error'
            );
        }
        else {
            if (empty($data["name"]) || empty($data["price"]) || empty($data["quantity"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                
                try {
                    $productRepository->update($data, true);
                    $output = array(
                        "status" => "success",
                        "message" => "Produit modifié avec succès !"
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
