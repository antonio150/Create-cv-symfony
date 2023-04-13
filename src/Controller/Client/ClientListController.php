<?php

namespace App\Controller\Client;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ClientListController extends AbstractController
{
    /**
     * @Route("api/v1/client/list", name="app_client_list")
     */
    public function list(ClientRepository $clientRepository): JsonResponse
    {
        $output = array();
        $temp = array();
        $data = $clientRepository->findBy(['is_deleted' => false]);
        
        foreach ($data as $item) {
            $temp["id"] = $item->getId();
            $temp["nom"] = $item->getNom();
            $temp["adresse"] = $item->getAdresse();
            $temp["nif"] = $item->getNif();
            $temp["stat"] = $item->getstat();
            $temp["cin"] = $item->getCin();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des clients',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
