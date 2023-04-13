<?php

namespace App\Controller\Client;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientGetByNameController extends AbstractController
{
    /**
     * @Route("/api/v1/client/get/by/name", name="app_client_get_by_name")
     */
    public function getByName(ClientRepository $clientRepository): JsonResponse
    {
        $output = array();
        $temp = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        $customer = $clientRepository->findBy(['nom' => $data["name"]]);
        if (empty($customer)) {
            $output = array(
                'message' => 'Client introuvable ! ',
                'status' => 'error'
            );
            return $this->json($output);
        }


        foreach ($customer as $item) {
            $temp["id"] = $item->getId();
            $temp["name"] = $item->getNom();
            $temp["address"] = $item->getAdresse();
            $temp["contact"] = $item->getContact();
            $temp["nif"] = $item->getNif();
            $temp["stat"] = $item->getStat();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Info Client',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
