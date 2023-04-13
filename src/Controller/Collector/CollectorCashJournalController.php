<?php

namespace App\Controller\Collector;

use App\Repository\ConsoCollectorRepository;
use App\Repository\PurchaseRepository;
use App\Repository\SupplyCollectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CollectorCashJournalController extends AbstractController
{
    /**
     * @Route("/api/v1/collector/cash/journal", name="app_collector_cash_journal")
     */
    public function cashJournal(ConsoCollectorRepository $consoCollectorRepository, SupplyCollectorRepository $supplyCollectorRepository, PurchaseRepository $purchaseRepository): JsonResponse
    {

        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();
        $supplyCollector = $supplyCollectorRepository->findBy(['collector' => $data["id"], 'is_deleted' => false], array('id' => 'DESC'));

        foreach ($supplyCollector as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["collector"] = $item->getCollector()->getUser()->getName();
            $temp["amount"] = $item->getAmount();
            $temp["method"] = $item->getMethod();
            $temp["description"] = "APPRO";
            $temp["category"] = "CREDIT";
            $temp["createdAt"] = $item->getCreatedAt();
            $temp["price"] = "-";
            $temp["quantity"] = "-";
            $temp["solde"] = $item->getBalance();
            $temp["unit_price"] = "-";
            $temp["qte"] = "-";
            array_push($output, $temp);
        }

        $conso = $consoCollectorRepository->findBy(['collector' => $data["id"], 'is_deleted' => false], array('id' => 'DESC'));

        foreach ($conso as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["collector"] = $item->getCollector()->getUser()->getName();
            $temp["amount"] = $item->getAmount();
            $temp["description"] = $item->getDescription();
            $temp["createdAt"] = $item->getCreatedAt();
            $temp["category"] = "DEBIT";
            // $temp["price"] = "-";
            // $temp["quantity"] = "-";
            $temp["solde"] = $item->getBalance();
            $temp["price"] = (empty($item->getUnitPrice()) ? '-' : $item->getUnitPrice());
            $temp["quantity"] = (empty($item->getQuantity()) ? '-' : $item->getQuantity());
            array_push($output, $temp);
        }

        // $purchase = $purchaseRepository->findBy(['collector' => $data["id"], 'is_deleted' => false], array('id' => 'DESC'));

        // foreach ($purchase as $item) {
        //     $temp = array();
        //     $temp["id"] = $item->getId();
        //     $temp["collector"] = $item->getCollector()->getUser()->getName();
        //     $temp["price"] = $item->getUnitPrice();
        //     $temp["quantity"] = $item->getQuantity();
        //     $temp["amount"] = $item->getAmount();
        //     $temp["createdAt"] = $item->getCreatedAt();
        //     $temp["category"] = "DEBIT";
        //     $temp["description"] = "ACHAT";
        //     $temp["solde"] = "-";
        //     array_push($output, $temp);
        // }

        return $this->json([
            'message' => 'Journal de caisse',
            'data' => $this->usortFilter($output),
            // 'data' => $output,
            'status' => 'success'
        ]);
    }

    public function usortFilter($item)
    {
        usort($item, function ($item1, $item2) {
            if ($item1['createdAt'] == $item2['createdAt']) return 0;
            return $item1['createdAt'] < $item2['createdAt'] ? -1 : 1;
        });
        return $item;
    }
}
