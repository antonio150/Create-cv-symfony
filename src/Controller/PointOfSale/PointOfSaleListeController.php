<?php

namespace App\Controller\PointOfSale;

use App\Repository\PointOfSaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PointOfSaleListeController extends AbstractController
{
    /**
     * @Route("/api/v1/point/of/sale/list", name="app_point_of_sale_list")
     */
    public function liste(PointOfSaleRepository $pointOfSaleRepository): JsonResponse
    {
        $pointOfSales = $pointOfSaleRepository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        $output = array();

        foreach ($pointOfSales as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["manager"] = $item->getManager()->getName();
            $temp["adress"] = $item->getAdress();
            $temp["contact"] = $item->getTelephone();
            $temp["name"] = $item->getName();
            $temp["acronym"] = $item->getSigle();
            $temp["balance"] = $item->getBalance();
            $temp["invoice"] = $this->generateReferenceInvoice($item->getInvoiceNumber(), $item->getSigle());
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des points de ventes',
            'data' => $output,
            'status' => 'success'
        ]);
    }

    public function generateReferenceInvoice($invoiceNumber, $sigle)
    {
        if (strlen($invoiceNumber) == 1) {
            $indice = "000" . $invoiceNumber;
        } elseif (strlen($invoiceNumber) == 2) {
            $indice = "00" . $invoiceNumber;
        } elseif (strlen($invoiceNumber) == 3) {
            $indice = "0" . $invoiceNumber;
        }
        return "FAC/" . $sigle. "/" . $indice;
    }
}
