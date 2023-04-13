<?php

namespace App\Controller\Client;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientDeleteController extends AbstractController
{
    /**
     * @Route("/client/delete", methods={"POST"}, name="app_client_delete")
     */
    public function delete(): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();
        $em = $this->getDoctrine()->getManager();
        $id = isset($data["id"]) ? $data["id"] : NULL;

        if ($id == NULL) {
            $output = array(
                "status" => "erreur",
                "message" => "Données introuvable, merci de contacter l'administrateur !"
            );
        } else {
            $parameter = array(
                "id" => $data["id"]
            );
            $repository = $em->getRepository(Client::class);
            $client = $repository->find($parameter);

            if (empty($client)) {
                $output = array(
                    "status" => "erreur",
                    "message" => "Client non disponible !"
                );
            } else {
                $client->setIsDeleted(true);
                $em->persist($client);
                $em->flush();
                $output = array(
                    "status" => "success",
                    "message" => "Client supprimé avec succès !"
                );
            }
        }
        return $this->json($output);
    }
}
