<?php

namespace App\Controller\CollectorStock;

use App\Entity\CollectorStock;
use App\Repository\CollectorRepository;
use App\Repository\CollectorStockRepository;
use App\Repository\ProductRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CollectorStockCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/collector/stock/create", name="app_collector_stock_create")
     */
    public function create(CollectorRepository $collectorRepository, ProductRepository $productRepository, CollectorStockRepository $collectorStockRepository): JsonResponse
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
            if (
                empty($data["product"]) ||
                empty($data["collector"])
            ) {
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



                $infoCollectorProduct = $collectorStockRepository->findOneBy(['collector' => $collector, 'product' => $product]);
                if (!empty($infoCollectorProduct)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Le couple existe déjà !"
                    );
                    return $this->json($output);
                }
                try {
                    $collectorStock = new CollectorStock($collector, $product);
                    $collectorStock->setQuantity($quantity);
                    $collectorStockRepository->add($collectorStock, true);
                    $output = array(
                        "status" => "success",
                        "message" => "Stock pour collecteur créé avec succès !"
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
