<?php

namespace App\Controller\CollectorStock;

use App\Repository\CollectorRepository;
use App\Repository\CollectorStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CollectorStockListController extends AbstractController
{
    /**
     * @Route("/api/v1/collector/stock/list", name="app_collector_stock_list")
     */
    public function liste(CollectorStockRepository $collectorStockRepository, CollectorRepository $collectorRepository): JsonResponse
    {
        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

         if (empty($data)) {
            $product = $collectorStockRepository->findAll(array('id' => 'DESC'));
        }
        else {
            $collectorID = $data["collectorID"];
            $collector = $collectorRepository->find($collectorID);
            $product = $collectorStockRepository->findBy(['collector' => $collector], array('id' => 'DESC'));
        }
        

        foreach ($product as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["product"] = $item->getProduct()->getName();
            $temp["collector"] = ''.$item->getCollector()->getUser()->getFirstName().' '.$item->getCollector()->getUser()->getName();
            $temp["quantity"] = $item->getQuantity();
            $temp["synchronizationAt"] = $item->getSynchronizedAt();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des stocks par collecteur',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
