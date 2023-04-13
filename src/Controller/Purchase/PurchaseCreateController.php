<?php

namespace App\Controller\Purchase;

use App\Entity\CollectorStock;
use App\Entity\ConsoCollector;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\SupplyStock;
use App\Repository\CollectorRepository;
use App\Repository\CollectorStockRepository;
use App\Repository\ConsoCollectorRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use App\Repository\SupplyStockRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/purchase/create", name="app_purchase_create")
     */
    public function create(ProductRepository $producRepository, CollectorRepository $collectorRepository, PurchaseRepository $purchaseRepository, CollectorStockRepository $collectorStockRepository, ConsoCollectorRepository $consoCollectorRepository): JsonResponse
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
                // empty($data["ref"]) ||
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
                    $info = $collectorRepository->collectorInfo($collector->getId());
                    // if ($info->getCredit() <= 0) {
                    //     $output = array(
                    //         "status" => "error",
                    //         "message" => "Veuillez recharger votre compte s'il vous plaît !"
                    //     );
                    //     return $this->json($output);
                    // }

                    $arrayProduct = isset($data["products"]) ? $data["products"] : NULL;
                    $amountAllProduct  = $this->calculAmount($arrayProduct);

                    // if ($info->getCredit() < $amountAllProduct) {
                    //     $output = array(
                    //         "status" => "error",
                    //         "message" => "Votre crédit actuel est insuffisant pour enregistrer cet achat !"
                    //     );
                    //     return $this->json($output);
                    // }

                    $ref = $this->generateReference($collectorID);

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

                        // ADD IN CONSO TABLE
                        $balance = $collector->getCredit();
                        $newBalance = $balance - $amount;
                        $description = "Achat " . $product->getName();
                        $conso = new ConsoCollector($collector, $amount, $description);
                        $conso->setBalance($newBalance);
                        $conso->setQuantity($qte);
                        $conso->setUnitPrice($unit_price);
                        $consoCollectorRepository->add($conso, true);

                        // MAJ BALANCE 
                        // $balance = $collector->balanceCalculator($info->getCredit(), $amountAllProduct);
                        $balance = $collector->balanceCalculator($info->getCredit(), $amount);
                        $collectorRepository->updateBalance($collector->getId(), $balance, true);

                        // ADD STOCK COLLECTOR
                        $stockCollector = new CollectorStock($collector, $product);
                        $isCoupleExist = $collectorStockRepository->findOneBy(["collector" => $collector, "product" => $product]);

                        if (empty($isCoupleExist)) {
                            $stockCollector->setQuantity($qte);
                            $collectorStockRepository->add($stockCollector, true);
                        } else {
                            $stockPresent = $isCoupleExist->getQuantity();
                            $stock = $stockCollector->addStockCalculator($stockPresent, $qte);
                            $collectorStockRepository->updateQuantity($isCoupleExist->getId(), $stock, true);
                        }
                    }


                    $output = array(
                        "status" => "success",
                        "message" => "Nouveau achat enregistré avec succès !"
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

    public function calculAmount($arrayProduct): float
    {
        $amountAllProduct = 0.00;

        foreach ($arrayProduct as $value) {
            $qte = $value["qte"];
            $unit_price = $value["unit_price"];
            $amountAllProduct += ($qte * $unit_price);
        }

        return $amountAllProduct;
    }

    public function generateReference($collectorID): string
    {
        return (new DateTime())->format('Ymd' . $collectorID . 'Hi');
    }
}
