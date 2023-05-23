<?php

namespace App\Controller\Profil;

use App\Entity\Profil;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilDeleteController extends AbstractController
{
    /**
     * @Route("/profil/profil/delete", name="app_profil_profil_delete")
     */
    public function index(): Response
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();
        $em = $this->getDoctrine()->getManager();
        $id = isset($data["id"]) ? $data["id"] : NULL;

        if ($id == NULL) {
            $output = array(
                "status" => "error",
                "message" => "Données introuvable, merci de contacter l'administrateur !"
            );
        } else {
            $parameter = array(
                "id" => $data["id"]
            );
            $repository = $em->getRepository(Profil::class);
            $client = $repository->find($parameter);

            if (empty($client)) {
                $output = array(
                    "status" => "error",
                    "message" => "Profil non disponible !"
                );
            } else {

                $client->setIsDeleted(true);
                try {
                    $em->persist($client);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Le profil a été supprimé avec succès !"
                    );
                } catch (Exception $ex) {

                    $output = array(
                        "status" => "error",
                        "message" => $ex->getMessage()
                    );
                }
            }
        }

        return $this->json($output);
    }
}