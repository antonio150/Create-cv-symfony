<?php

namespace App\Controller\SupplyStock;

use App\Repository\SupplyStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SupplyStockByIdController extends AbstractController
{
    /**
     * @Route("/api/v1/stock/by/id", name="app_supply_stock_by_id")
     */
    public function getById(SupplyStockRepository $supplyStockRepository): JsonResponse
    {
        $output = array();
        $temp = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        $stock = $supplyStockRepository->findBy(['id' => $data["id"]]);
        
        if (empty($stock)) {
            $output = array(
                'message' => 'Stock introuvable ! ',
                'status' => 'erreur'
            );
            return $this->json( $output);
        } 


        foreach ($stock as $item) {
            $temp["id"] = $item->getId();
            $temp["product"] = $item->getProduct()->getName();
            $temp["quantity"] = $item->getQuantity();
            $temp["difference"] = $item->getDifference();
            $temp["waste"] = $item->getWaste();
            $temp["missingWeight"] = $item->getMissingWeight();
            $temp["received"] = $item->getQuantity();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Info Stock',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
