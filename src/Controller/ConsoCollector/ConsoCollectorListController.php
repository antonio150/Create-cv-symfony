<?php

namespace App\Controller\ConsoCollector;

use App\Repository\CollectorRepository;
use App\Repository\ConsoCollectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConsoCollectorListController extends AbstractController
{
    /**
     * @Route("/api/v1/conso/collector/list", name="app_conso_collector_list")
     */
    public function list(ConsoCollectorRepository $consoCollectorRepository, CollectorRepository $collectorRepository): JsonResponse
    {

        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            $conso = $consoCollectorRepository->findBy(['is_deleted' => false], array('id' => 'DESC'));
        } else {
            $collectorID = $data["collectorID"];
            $collector = $collectorRepository->find($collectorID);
            $conso = $consoCollectorRepository->findBy(['is_deleted' => false, 'collector' => $collector], array('id' => 'DESC'));
        }

        foreach ($conso as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["collector"] = $item->getCollector()->getUser()->getFirstName().' '.$item->getCollector()->getUser()->getName();
            $temp["amount"] = $item->getAmount();
            $temp["description"] = $item->getDescription();
            $temp["createdAt"] = $item->getCreatedAt();
            array_push($output, $temp);
        }
        return $this->json([
            'message' => 'La liste des consommation des collecteurs',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
