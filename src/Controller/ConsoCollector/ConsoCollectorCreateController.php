<?php

namespace App\Controller\ConsoCollector;

use App\Entity\ConsoCollector;
use App\Repository\CollectorRepository;
use App\Repository\ConsoCollectorRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConsoCollectorCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/conso/collector/create", name="app_conso_collector_create")
     */
    public function create(ConsoCollectorRepository $consoCollectorRepository, CollectorRepository $collectorRepository, UtilisateurRepository $utilisateurRepository): JsonResponse
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

            if (empty($data["collector"]) || empty($data["amount"]) || empty($data["description"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                $userId = isset($data["collector"]) ? $data["collector"] : NULL;
                $description = isset($data["description"]) ? $data["description"] : NULL;
                $amount = isset($data["amount"]) ? $data["amount"] : NULL;


                $collector = $collectorRepository->findOneBy(['user' => $userId]);
                if (empty($collector)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Collecteur introuvable !"
                    );
                    return $this->json($output);
                }

                try {
                    $balance = $collector->getCredit();
                    $newBalance = $balance - $amount;
                    $conso = new ConsoCollector($collector, $amount, $description);
                    $conso->setBalance($newBalance);
                    $consoCollectorRepository->add($conso, true);
                    // MAJ CREDIT COLLECTOR
                    $collectorRepository->updateBalance($collector->getId(), $newBalance, true);

                    $output = array(
                        "status" => "success",
                        "message" => "Consommation collecteur enregistré avec succès !"
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
