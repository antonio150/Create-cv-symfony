<?php

namespace App\Controller\SupplyStock;

use App\Entity\SupplyStock;
use App\Repository\CollectorRepository;
use App\Repository\ProductRepository;
use App\Repository\SupplyStockRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SupplyStockSynchroController extends AbstractController
{
    /**
     * @Route("/api/v1/supply/stock/synchro", name="app_supply_stock_synchro")
     */
    public function synchronization(SupplyStockRepository $supplyStockRepository, CollectorRepository $collectorRepository, ProductRepository $productRepository): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();
        
        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error'
            );
        } else {
            if (empty($data["collector"]) || empty($data["product"]) || empty($data["quantity"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $collectorID = isset($data["collector"]) ? $data["collector"] : NULL;
                $productID = isset($data["product"]) ? $data["product"] : NULL;
                $quantity = isset($data["quantity"]) ? $data["quantity"] : NULL;

                $collector = $collectorRepository->find($collectorID);
                if (empty($collector)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Collecteur introuvable !"
                    );
                    return $this->json($output);
                }

                $product = $productRepository->find($productID);
                if (empty($product)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Produit introuvable !"
                    );
                    return $this->json($output);
                }

                try {
                    
                    $supplyStock = new SupplyStock($product, $quantity, $collector);
                    $supplyStockRepository->add($supplyStock, true);

                    $output = array(
                        "status" => "success",
                        "message" => "Approvisionnement Stock enregistré avec succès !"
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
