<?php

namespace App\Controller\Formation;

use App\Entity\Formation;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationDeleteController extends AbstractController
{
    /**
     * @Route("/formation/formation/delete", name="app_formation_formation_delete")
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
            $repository = $em->getRepository(Formation::class);
            $formation = $repository->find($parameter);

            if (empty($formation)) {
                $output = array(
                    "status" => "error",
                    "message" => "Formation non disponible !"
                );
            } else {

                $formation->setDeleted(true);
                try {
                    $em->persist($formation);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Formation supprimé avec success !"
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