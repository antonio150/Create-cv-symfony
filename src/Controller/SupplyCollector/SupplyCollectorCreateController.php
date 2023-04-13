<?php

namespace App\Controller\SupplyCollector;

use App\Entity\ConsoCollector;
use App\Entity\SupplyCollector;
use App\Repository\CollectorRepository;
use App\Repository\ConsoCollectorRepository;
use App\Repository\SupplyCollectorRepository;
use App\Repository\UtilisateurRepository;
use App\Services\Helper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SupplyCollectorCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/supply/collector/create", name="app_supply_collector_create")
     */
    public function create(SupplyCollectorRepository $supplyCollectorRepository, CollectorRepository $collectorRepository, UtilisateurRepository $utilisateurRepository, ConsoCollectorRepository $consoCollectorRepository): JsonResponse
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
            if (empty($data["collector"]) || empty($data["method"]) || empty($data["amount"]) || empty($data["user"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $collectorID = isset($data["collector"]) ? $data["collector"] : NULL;
                $method = isset($data["method"]) ? $data["method"] : NULL;
                $amount = isset($data["amount"]) ? $data["amount"] : NULL;
                $userID = isset($data["user"]) ? $data["user"] : NULL;

                $collector = $collectorRepository->find($collectorID);
                if (empty($collector)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Collecteur introuvable !"
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
                    $balance = $collector->getCredit();
                    $newBalance = $balance + $amount;
                    $supplyCollector = new SupplyCollector($collector, $method, $amount, $user);
                    $supplyCollector->setBalance(($balance + $amount));
                    $supplyCollectorRepository->add($supplyCollector, true);
                    // MAJ CREDIT COLLECTOR
                    $collectorRepository->updateBalance($collector->getId(), $newBalance, true);

                    $output = array(
                        "status" => "success",
                        "message" => "Appro collecteur enregistré avec succès !"
                    );

                    // // ADD AUTO FEE WITHDRAWAL IN CONSO ?
                    // $hepler = new Helper();
                    // $fee = $hepler->getWithdrawalFee($method, $amount);
                    // $description = "Frais de retrait ".$method;
                    // $conso = new ConsoCollector($collector, $amount, $description);
                    // $consoCollectorRepository->add($conso, true);

                    $output = array(
                        "status" => "success",
                        "message" => "Appro collecteur enregistré avec succès !",
                        // "fee" => $fee
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
