<?php

namespace App\Controller\Utilisateur;

use App\Entity\Utilisateur;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurBlockedController extends AbstractController
{
    /**
     * @Route("/api/v1/user/blocked", name="app_user_blocked")
     */
    public function blocked(): JsonResponse
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
            $user = $repository->find($parameter);

            if (empty($user)) {
                $output = array(
                    "status" => "erreur",
                    "message" => "Utilisateur non disponible !"
                );
            } else {

                $user->setIsBlocked(true);
                $user->setUpdatedAt(new DateTime());
                try {
                    $em->persist($user);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Utilisateur bloqué avec succès !"
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

     /**
     * @Route("/api/v1/user/unblocked", name="app_user_unblocked")
     */
    public function unBlocked(): JsonResponse
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
            $user = $repository->find($parameter);

            if (empty($user)) {
                $output = array(
                    "status" => "erreur",
                    "message" => "Utilisateur non disponible !"
                );
            } else {

                $user->setIsBlocked(false);
                $user->setUpdatedAt(new DateTime());
                try {
                    $em->persist($user);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Utilisateur dé-bloqué avec succès !"
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
