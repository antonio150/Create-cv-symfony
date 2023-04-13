<?php

namespace App\Controller\SupplyStock;

use App\Repository\CollectorRepository;
use App\Repository\SupplyCollectorRepository;
use App\Repository\SupplyStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SupplyStockListController extends AbstractController
{
    /**
     * @Route("/api/v1/supply/stock/list", name="app_supply_stock_list")
     */
    public function liste(SupplyStockRepository $supplyStockRepository, CollectorRepository $collectorRepository): JsonResponse
    {
        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            $supplyStock = $supplyStockRepository->findBy(['is_deleted' => false], array('id' => 'DESC'));
        } else {
            $collectorID = $data["collectorID"];
            $collector = $collectorRepository->find($collectorID);
            $supplyStock = $supplyStockRepository->findBy(['is_deleted' => false, 'collector' => $collector], array('id' => 'DESC'));
        }

        foreach ($supplyStock as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["collector"] = $item->getCollector()->getUser()->getFirstName().' '.$item->getCollector()->getUser()->getName();
            $temp["product"] = $item->getProduct()->getName();
            $temp["quantity"] = $item->getQuantity();
            $temp["createdAt"] = $item->getCreatedAt();
            $temp["missing_weight"] = $item->getMissingWeight();
            $temp["difference"] = $item->getDifference();
            $temp["waste"] = $item->getWaste();
            $temp["statut"] = $item->getStatut();
            $temp["stockID"] = $item->getId();
            $temp["received"] = ($item->getStatut() == "En attente") ? 0.00 : ( $item->getQuantity() - ($item->getMissingWeight() + $item->getDifference() + $item->getWaste()) );
            array_push($output, $temp);
        }
        return $this->json([
            'message' => 'La liste des appro des collecteurs',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
