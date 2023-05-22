<?php

namespace App\Controller\Reference;

use App\Entity\Reference;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferenceDeleteController extends AbstractController
{
    /**
     * @Route("/reference/reference/delete", name="app_reference_reference_delete")
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
            $repository = $em->getRepository(Reference::class);
            $info = $repository->find($parameter);

            if (empty($info)) {
                $output = array(
                    "status" => "erreur",
                    "message" => "Reference non disponible !"
                );
            } else {

                $info->setDeleted(true);
                try {
                    $em->persist($info);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Reference supprimé avec succès !"
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