<?php

namespace App\Controller\ConsoPointOfSale;

use App\Repository\ConsoPointOfSaleRepository;
use App\Repository\PointOfSaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsoPointOfSaleListeController extends AbstractController
{
    /**
     * @Route("/api/v1/conso/point/of/sale/liste", name="app_conso_point_of_sale_liste")
     */
    public function conso_pos_liste(ConsoPointOfSaleRepository $consoPointOfSaleRepository, PointOfSaleRepository $pointOfSaleRepository): Response
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();

        if (empty($data)) {
            $conso = $consoPointOfSaleRepository->findAll();
        } else {
            $pointOfSaleId = $data["pointOfSaleId"];
            $pointOfSale = $pointOfSaleRepository->find($pointOfSaleId);

            $conso = $consoPointOfSaleRepository->findBy(
                [
                    'is_deleted' => false,
                    'pointOfSale' => $pointOfSale
                ],
                array('id' => 'DESC')
            );
        }

        foreach ($conso as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["pointOfSale"] = $item->getPointOfSale()->getName();
            $temp["amount"] = $item->getAmount();
            $temp["description"] = $item->getDescription();
            $temp["createdAt"] = $item->getCreatedAt();
            array_push($output, $temp);
        }
        return $this->json([
            'message' => 'La liste des consommation des points de ventes',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
