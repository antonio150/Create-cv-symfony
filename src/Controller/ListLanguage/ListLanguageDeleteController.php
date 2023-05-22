<?php

namespace App\Controller\ListLanguage;

use App\Entity\ListLanguage;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListLanguageDeleteController extends AbstractController
{
    /**
     * @Route("/list/language/list/language/delete", name="app_list_language_list_language_delete")
     */
    public function index(
        Request $request
    ): Response {
        $data = [];
        if ($content = $request->getContent()) {
            $data = json_decode($content, true);
        }
        $id = isset($data["id"]) ? $data["id"] : NULL;
        $em = $this->getDoctrine()->getManager();


        if ($id == NULL) {
            $output = array(
                "status" => "erreur",
                "message" => "Données introuvable, merci de contacter l'administrateur !"
            );
        } else {
            $parameter = array(
                "id" => $data["id"]
            );
            $repository = $em->getRepository(ListLanguage::class);
            $formation = $repository->find($parameter);

            if (empty($formation)) {
                $output = array(
                    "status" => "erreur",
                    "message" => "List Language non disponible !"
                );
            } else {

                $formation->setDeleted(true);
                try {
                    $em->persist($formation);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "ListLanguage supprimé avec succès !"
                    );
                } catch (Exception $ex) {

                    $output = array(
                        "status" => "erreur",
                        "message" => $ex->getMessage()
                    );
                }
            }
        }

        return $this->json(
            $output
        );
    }
}
