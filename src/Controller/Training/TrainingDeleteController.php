<?php

namespace App\Controller\Training;

use App\Entity\ProfessionalTraining;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingDeleteController extends AbstractController
{
    /**
     * @Route("/training/training/delete", name="app_training_training_delete")
     */
    public function index(
        Request $request
    ): Response
    {
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
            $repository = $em->getRepository(ProfessionalTraining::class);
            $formation = $repository->find($parameter);

            if (empty($formation)) {
                $output = array(
                    "status" => "error",
                    "message" => "Training non disponible !"
                );
            } else {

                $formation->setisDeleted(true);
                try {
                    $em->persist($formation);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Training supprimé avec succès !"
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