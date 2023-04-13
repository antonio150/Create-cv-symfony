<?php

namespace App\Controller\Collector;

use App\Repository\CollectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CollectorGetByIdController extends AbstractController
{
    /**
     * @Route("/api/v1/collector/get/by/id", name="app_collector_get_by_id")
     */
    public function getInfo(CollectorRepository $collectorRepository): JsonResponse
    {
        $output = array();
        $temp = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        $collector = $collectorRepository->findBy(['id' => $data["id"]]);
        
        if (empty($collector)) {
            $output = array(
                'message' => 'Collector introuvable ! ',
                'status' => 'error'
            );
            return $this->json( $output);
        } 


        foreach ($collector as $item) {
            $temp["id"] = $item->getId();
            $temp["name"] = $item->getUser()->getName();
            $temp["balance"] = $item->getCredit();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Info Collector',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
