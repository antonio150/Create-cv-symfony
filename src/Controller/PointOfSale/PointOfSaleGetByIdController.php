<?php

namespace App\Controller\PointOfSale;

use App\Repository\PointOfSaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PointOfSaleGetByIdController extends AbstractController
{
    /**
     * @Route("/api/v1/point/of/sale/get/by/id", name="app_point_of_sale_get_by_id")
     */
    public function getById(PointOfSaleRepository $pointOfSaleRepository): JsonResponse
    {
        $output = array();
        $temp = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'erreur'
            );
        }

        $pointOfSales = $pointOfSaleRepository->findBy(['id' => $data["id"]]);

        if (empty($pointOfSales)) {
            $output = array(
                'message' => 'Point de vente introuvable ! ',
                'status' => 'error'
            );
            return $this->json($output);
        }

        foreach ($pointOfSales as $item) {
            $temp["id"] = $item->getId();
            $temp["name"] = $item->getName();
            $temp["adress"] = $item->getTelephone();
            $temp["manager"] = $item->getManager()->getId();
            $temp["acronym"] = $item->getSigle();
            $temp["invoiceNumber"] = $item->getInvoiceNumber();
            $temp["balance"] = $item->getBalance();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Information concernant le point de vente',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
