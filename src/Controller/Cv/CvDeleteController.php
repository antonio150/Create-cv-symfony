<?php

namespace App\Controller\Cv;

use App\Entity\Curriculum;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvDeleteController extends AbstractController
{
    /**
     * @Route("/cv/cv/delete", name="app_cv_cv_delete")
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
                "status" => "error",
                "message" => "Données introuvable, merci de contacter l'administrateur !"
            );
        } else {
            $parameter = array(
                "id" => $data["id"]
            );
            $repository = $em->getRepository(Curriculum::class);
            $formation = $repository->find($parameter);

            if (empty($formation)) {
                $output = array(
                    "status" => "error",
                    "message" => "CV non disponible !"
                );
            } else {

                $formation->setDeleted(true);
                try {
                    $em->persist($formation);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "CV supprimé avec succés !"
                    );
                } catch (Exception $ex) {

                    $output = array(
                        "status" => "error",
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
