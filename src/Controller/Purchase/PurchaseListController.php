<?php

namespace App\Controller\Purchase;

use App\Repository\CollectorRepository;
use App\Repository\PurchaseRepository;
use App\Repository\SupplyStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseListController extends AbstractController
{
    /**
     * @Route("/api/v1/purchase/list", name="app_purchase_list")
     */
    public function list(PurchaseRepository $purchaseRepository, SupplyStockRepository $supplyStockRepository, CollectorRepository $collectorRepository): JsonResponse
    {

        $output = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

         if (empty($data)) {
            $purchase = $purchaseRepository->findBy(['is_deleted' => false], array('id' => 'DESC'));
        }
        else {
            $collectorID = $data["collectorID"];
            $collector = $collectorRepository->find($collectorID);
            $purchase = $purchaseRepository->findBy(['is_deleted' => false, 'collector' => $collector], array('id' => 'DESC'));
        }
        $output = array();

        foreach ($purchase as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["product"] = $item->getProduct()->getName();
            $temp["collector"] = ''.$item->getCollector()->getUser()->getFirstName().' '.$item->getCollector()->getUser()->getName();
            $temp["price"] = $item->getUnitPrice();
            $temp["quantity"] = $item->getQuantity();
            $temp["amount"] = $item->getAmount();
            $temp["reference"] = $item->getReference();
            $temp["createdAt"] = $item->getCreatedAt();
            $temp["placename"] = $item->getPlacenameOfCollection();
            $temp["statutPurchase"] = $item->getStatut();
            array_push($output, $temp);
        }
        return $this->json([
            'message' => 'La liste des achats',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
