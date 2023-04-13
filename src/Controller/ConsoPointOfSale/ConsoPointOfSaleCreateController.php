<?php

namespace App\Controller\ConsoPointOfSale;

use App\Entity\ConsoPointOfSale;
use App\Repository\ConsoPointOfSaleRepository;
use App\Repository\PointOfSaleRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsoPointOfSaleCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/conso/point/of/sale/create", name="app_conso_point_of_sale_create")
     */
    public function create_conso_pos(ConsoPointOfSaleRepository $consoPointOfSaleRepository, UtilisateurRepository $utilisateurRepository, PointOfSaleRepository $pointOfSaleRepository): Response
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

            if (empty($data["pointOfSale"]) || empty($data["amount"]) || empty($data["description"]) || empty($data["user"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $userId = isset($data["user"]) ? $data["user"] : NULL;
                $description = isset($data["description"]) ? $data["description"] : NULL;
                $amount = isset($data["amount"]) ? $data["amount"] : NULL;
                $pointOfSaleId = isset($data["pointOfSale"]) ? $data["pointOfSale"] : NULL;
                $pointOfSale = $pointOfSaleRepository->find($pointOfSaleId);

                if (empty($pointOfSale)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Point de vente introuvable !"
                    );
                    return $this->json($output);
                }

                $user = $utilisateurRepository->find($userId);

                if (empty($user)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Utilisateur introuvable !"
                    );
                    return $this->json($output);
                }

                try {
                    $solde = $pointOfSale->getBalance();
                    $balance = $solde - $amount;
                    $conso = new ConsoPointOfSale();
                    $conso->setBalance($balance);
                    $conso->setDescription($description);
                    $conso->setAmount($amount);
                    $conso->setPointOfSale($pointOfSale);
                    $conso->setCreatedBy($user);
                    $consoPointOfSaleRepository->add($conso, true);
                    // MAJ CREDIT POS
                    $pointOfSaleRepository->updateBalance($pointOfSale, $balance, true);
                    $output = array(
                        "status" => "success",
                        "message" => "Consommation Point de vente enregistrée avec succès !"
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
