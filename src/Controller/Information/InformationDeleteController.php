<?php

namespace App\Controller\Information;

use App\Entity\PersonalInformation;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationDeleteController extends AbstractController
{
    /**
     * @Route("/information/information/delete", name="app_information_information_delete")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager

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
            $repository = $em->getRepository(PersonalInformation::class);
            $info = $repository->find($parameter);

            if (empty($info)) {
                $output = array(
                    "status" => "erreur",
                    "message" => "Information non disponible !"
                );
            } else {

                $info->setIsDeleted(true);
                try {
                    $em->persist($info);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Information supprimé avec succès !"
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