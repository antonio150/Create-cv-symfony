<?php

namespace App\Controller\SupplyCollector;

use App\Entity\SupplyCollector;
use App\Repository\SupplyCollectorRepository;
use App\Repository\SupplyStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SupplyCollectorListController extends AbstractController
{
    /**
     * @Route("/api/v1/supply/collector/list", name="app_supply_collector_list")
     */
    public function list(SupplyCollectorRepository $supplyCollectorRepository): JsonResponse
    {
        $output = array();
        $supplyCollector = $supplyCollectorRepository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        foreach ($supplyCollector as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["collector"] = $item->getCollector()->getUser()->getName();
            $temp["amount"] = $item->getAmount();
            $temp["method"] = $item->getMethod();
            $temp["createdAt"] = $item->getCreatedAt();
            $temp["createdBy"] = $item->getCreatedBy()->getUserIdentifier();
            array_push($output, $temp);
        }
        return $this->json([
            'message' => 'La liste des appro des collecteurs',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
