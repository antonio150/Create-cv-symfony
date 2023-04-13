<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Repository\CollectorRepository;
use App\Repository\CollectorStockRepository;
use App\Repository\ConsoCollectorRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseSynchroController extends AbstractController
{
    /**
     * @Route("/api/v1/purchase/synchro", name="app_purchase_synchro")
     */
    public function synchro(ProductRepository $producRepository, 
    CollectorRepository $collectorRepository, 
    PurchaseRepository $purchaseRepository, 
    CollectorStockRepository $collectorStockRepository, 
    ConsoCollectorRepository $consoCollectorRepository): JsonResponse
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
                empty($data["products"]) ||
                empty($data["collector_id"]) ||
                empty($data["placename"])
            ) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {

                $collectorID = isset($data["collector_id"]) ? $data["collector_id"] : NULL;
                $placename = isset($data["placename"]) ? $data["placename"] : NULL;
                $amount = isset($data["amount"]) ? $data["amount"] : NULL;
                $ref = isset($data["ref"]) ? $data["ref"] : NULL;
                $collector = $collectorRepository->find($collectorID);
                if (empty($collector)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Collecteur introuvable !"
                    );
                    return $this->json($output);
                }

                try {
                    // Verification Solde Crédit
                    $arrayProduct = isset($data["products"]) ? $data["products"] : NULL;
                    foreach ($arrayProduct as $value) {

                        $product = $producRepository->find($value["product_id"]);
                        if (empty($product)) {
                            $output = array(
                                "status" => "erreur",
                                "message" => "Produit introuvable !"
                            );
                            return $this->json($output);
                        }

                        $qte = $value["qte"];
                        $unit_price = $value["unit_price"];
                        $amount = $value["amount"];
                        // ADD PURCHASE
                        $purchase = new Purchase($product, $collector, $qte, $unit_price, $amount, $placename, $ref);
                        $purchaseRepository->add($purchase, true);
                    }
                    $output = array(
                        "status" => "success",
                        "message" => "Nouveau achat synchronisé avec succès !"
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
