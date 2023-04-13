<?php

namespace App\Controller\PointOfSaleStock;

use App\Entity\PointOfSale;
use App\Entity\PointOfSaleStock;
use App\Repository\PointOfSaleRepository;
use App\Repository\PointOfSaleStockRepository;
use App\Repository\ProductRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PointOfSaleStockCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/point/of/sale/stock/create", name="app_point_of_sale_stock_create")
     */
    public function create(UtilisateurRepository $utilisateurRepository, PointOfSaleStockRepository $pointOfSaleStockRepository, PointOfSaleRepository $pointOfSaleRepository, ProductRepository $productRepository): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error',
                'data' => $data
            );
        } else {
            if (empty($data["quantity"]) || empty($data["pointOfSale"]) || empty($data["product"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {

                $productID = isset($data["product"]) ? $data["product"] : NULL;
                $pointOfSaleID = isset($data["pointOfSale"]) ? $data["pointOfSale"] : NULL;
                $userID = isset($data["user"]) ? $data["user"] : NULL;
                $quantity = isset($data["quantity"]) ? $data["quantity"] : NULL;

                $product = $productRepository->find($productID);
                if (empty($product)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Produit introuvable !"
                    );
                    return $this->json($output);
                }

                $pointOfSale = $pointOfSaleRepository->find($pointOfSaleID);
                if (empty($pointOfSale)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Point de vente introuvable !"
                    );
                    return $this->json($output);
                }

                $user = $utilisateurRepository->find($userID);
                if (empty($user)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Utilisateur introuvable !"
                    );
                    return $this->json($output);
                }

                if ($product->getQantity() < $quantity) {
                    $output = array(
                        "status" => "error",
                        "message" => "Stock insuffisant !"
                    );
                    return $this->json($output);
                }

                try {

                    $pointOfSaleStock = new PointOfSaleStock($product, $pointOfSale, $quantity, $user);
                    $pointOfSaleStock->setPointOfSales($pointOfSale);
                    $pointOfSaleStockRepository->add($pointOfSaleStock, true);

                    // update stock product table central
                    $productQty = $product->getQantity();
                    $productStock = $productQty - $quantity;
                    $productRepository->updateStock($product->getId(), number_format($productStock, 3), true);

                    $output = array(
                        "status" => "success",
                        "message" => "Approvisionnement Point de vente enregistré avec succès !"
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
