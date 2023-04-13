<?php

namespace App\Controller\Client;

use App\Entity\Client;
use App\Entity\Utilisateur;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientCreateController extends AbstractController
{
    /**
     * @Route("api/v1/client/create",  methods={"POST"}, name="app_client_create")
     */
    public function create(): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();

        $em = $this->getDoctrine()->getManager();

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error'
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
                $userId = isset($data["userId"]) ? $data["userId"] : NULL;
                $contact = isset($data["contact"]) ? $data["contact"] : NULL;

                $parameter = array(
                    "id" => $userId
                );

                $reposUser = $em->getRepository(Utilisateur::class);
                $user = $reposUser->find($parameter);

                if (empty($user)) {
                    $output = array(
                        "status" => "error",
                        "message" => "Utilisateur introuvable !"
                    );
                } else {
                    $client = new Client($nom, $adresse, $cin, $nif, $stat, $user);
                    $client->setContact($contact);
                    try {
                        $em->persist($client);
                        $em->flush();

                        $output = array(
                            "status" => "success",
                            "message" => "Nouveau client enregistré avec succès !"
                        );
                    } catch (Exception $ex) {

                        $output = array(
                            "status" => "error",
                            "message" => $ex->getMessage()
                        );
                    }
                }
            }
        }
        return $this->json($output);
    }
}
