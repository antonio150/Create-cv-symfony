<?php

namespace App\Controller\Collector;

use App\Repository\CollectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CollectorListController extends AbstractController
{
    /**
     * @Route("/api/v1/collector/listes", name="app_collector_list")
     */
    public function index(CollectorRepository $collectorRepository): JsonResponse
    {
        $collector = $collectorRepository->findBy(['is_deleted' => false], array('id' => 'DESC'));
        
        $output = array();

        foreach ($collector as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["cin"] = $item->getCin();
            $temp["credit"] = $item->getCredit();
            $temp["user"] = $item->getUser()->getName();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des collecteurs',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
