<?php

namespace App\Controller\Utilisateur;

use App\Entity\Utilisateur;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurDeleteController extends AbstractController
{
    /**
     * @Route("/api/v1/user/delete", name="app_user_delete")
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
            $repository = $em->getRepository(Utilisateur::class);
            $client = $repository->find($parameter);

            if (empty($client)) {
                $output = array(
                    "status" => "erreur",
                    "message" => "Utilisateur non disponible !"
                );
            } else {

                $client->setIsDeleted(true);
                try {
                    $em->persist($client);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Utilisateur supprimé avec succès !"
                    );
                } catch (Exception $ex) {

                    $output = array(
                        "status" => "erreur",
                        "message" => $ex->getMessage()
                    );
                }
            }
        }

        return $this->json($output);
    }
}
