<?php

namespace App\Controller\SupplyStock;

use App\Entity\Waste;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use App\Repository\SupplyStockRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\WasteRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SupplyUpdateStatusController extends AbstractController
{
    /**
     * @Route("/api/v1/supply/update", name="app_supply_stock_update_status")
     */
    public function update(SupplyStockRepository $supplyStockRepository, UtilisateurRepository $utilisateurRepository, ProductRepository $productRepository, WasteRepository $wasteRepository, PurchaseRepository $purchaseRepository): JsonResponse
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
            if (empty($data["id"]) || empty($data["user"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {

                // Check User
                $user = $utilisateurRepository->find($data["user"]);
                if (empty($user)) {
                    $output = array(
                        'message' => 'Utilisateur introuvable, merci de vous reconnecter !',
                        'status' => 'error'
                    );
                    return $this->json($output);
                }

                try {
                    // Update Appro 
                    $supplyStockRepository->update($data, true, $user);

                    // Update stock Product
                    $supplyStock = $supplyStockRepository->find($data["id"]);

                    //$purchase = $supplyStock->getPurchase();
                    $product = $supplyStock->getProduct();
                    $stock = $product->getQantity();

                    // $weightToRemove =  floatval($data["quantity"]) - (floatval($data["difference"]) +
                    //     floatval($data["waste"]) +
                    //     floatval($data["missingWeight"]));

                    $weightToRemove =  floatval($data["quantity"]) - (floatval($data["difference"]) + floatval($data["waste"]));
                    $newStock = floatval($stock) +  $weightToRemove;
                    $productRepository->updateStock($product->getId(), number_format($newStock, 2), true);

                    // Creation suivi Dechet
                    if($data["waste"] != 0.00){
                        $waste = new Waste($supplyStock);
                        $wasteRepository->add($waste, true);
                    }
                    
                    $output = array(
                        "status" => "success",
                        "message" => "Appro modifié avec succès !"
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
