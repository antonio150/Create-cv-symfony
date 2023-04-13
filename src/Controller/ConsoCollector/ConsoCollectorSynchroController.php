<?php

namespace App\Controller\ConsoCollector;

use App\Entity\ConsoCollector;
use App\Repository\CollectorRepository;
use App\Repository\ConsoCollectorRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConsoCollectorSynchroController extends AbstractController
{
    /**
     * @Route("/api/v1/conso/collector/synchro", name="app_conso_collector_synchro")
     */
    public function synchro(ConsoCollectorRepository $consoCollectorRepository, CollectorRepository $collectorRepository): JsonResponse
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

            if (empty($data["collector"]) || empty($data["amount"]) || empty($data["description"]) || empty($data["balance"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $userId = isset($data["collector"]) ? $data["collector"] : NULL;
                $description = isset($data["description"]) ? $data["description"] : NULL;
                $amount = isset($data["amount"]) ? $data["amount"] : NULL;
                $balance = isset($data["balance"]) ? $data["balance"] : NULL;
                $qte = isset($data["qte"]) ? $data["qte"] : NULL;
                $unit_price = isset($data["unit_price"]) ? $data["unit_price"] : NULL;


                $collector = $collectorRepository->findOneBy(['user' => $userId]);
                if (empty($collector)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Collecteur introuvable !"
                    );
                    return $this->json($output);
                }

                try {
                    $conso = new ConsoCollector($collector, $amount, $description);
                    $conso->setBalance($balance);
                    $conso->setUnitPrice($unit_price);
                    $conso->setQuantity($qte);
                    $consoCollectorRepository->add($conso, true);
                    $output = array(
                        "status" => "success",
                        "message" => "Consommation collecteur synchronisé avec succès !"
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
