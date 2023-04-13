<?php

namespace App\Controller\SupplyPointOfSale;

use App\Entity\PointOfSale;
use App\Entity\SupplyPointOfSale;
use App\Repository\PointOfSaleRepository;
use App\Repository\SupplyPointOfSaleRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SupplyPointOfSaleCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/supply/of/point/of/sale/create", name="app_supply_point_of_sale_create")
     */
    public function appro(SupplyPointOfSaleRepository $supplyPointOfSaleRepository,
                          PointOfSaleRepository $pointOfSaleRepository,
                          UtilisateurRepository $utilisateurRepository): JsonResponse
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
            if (empty($data["pointOfSale"]) || empty($data["amount"]) || empty($data["user"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $pointOfSaleID = isset($data["pointOfSale"]) ? $data["pointOfSale"] : NULL;
                $amount = isset($data["amount"]) ? $data["amount"] : NULL;
                $userID = isset($data["user"]) ? $data["user"] : NULL;
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
                try {
                    $supplyPointOfSale = new SupplyPointOfSale($pointOfSale, $user, $amount);
                    $balance = $pointOfSale->getBalance() + $amount;
                    $supplyPointOfSale->setBalance($balance);
                    $supplyPointOfSaleRepository->add($supplyPointOfSale, true);

                    $pointOfSaleRepository->updateBalance($pointOfSale, $balance, true);
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
