<?php

namespace App\Controller\Client;

use App\Entity\Client;
use App\Services\Common;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientUpdateController extends AbstractController
{
    /**
     * @Route("/client/update", methods={"POST"}, name="app_client_update")
     */
    public function update(): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Client::class);

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'erreur'
            );
        } else {
            if (empty($data["nom"]) || empty($data["adresse"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'erreur'
                );
            } else {
                $nom = isset($data["nom"]) ? $data["nom"] : NULL;
                $adresse = isset($data["adresse"]) ? $data["adresse"] : NULL;
                $cin = isset($data["cin"]) ? $data["cin"] : NULL;
                $nif = isset($data["nif"]) ? $data["nif"] : NULL;
                $stat = isset($data["stat"]) ? $data["stat"] : NULL;
                $id = isset($data["id"]) ? $data["id"] : NULL;

                if (!empty($id)) {
                    $param = array(
                        "id" => $data["id"]
                    );

                    $client = $repository->find($param);

                    if (empty($client)) {
                        $output = array(
                            "status" => "erreur",
                            "message" => "Client introuvable dans le système !"
                        );
                    } else {

                        $client->setNom($nom);
                        $client->setAllAttributes($nom, $adresse, $cin, $nif, $stat);
                        $em->persist($client);
                        $em->flush();
                        $output = array(
                            "status" => "success",
                            "message" => "Modification terminée avec succès !"
                        );
                    }
                }
            }
        }

        return $this->json($output);
    }
}
