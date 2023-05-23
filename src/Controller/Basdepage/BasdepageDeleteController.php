<?php

namespace App\Controller\Basdepage;

use App\Entity\BasDePage;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasdepageDeleteController extends AbstractController
{
    /**
     * @Route("/basdepage/basdepage/delete", name="app_basdepage_basdepage_delete")
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
            $repository = $em->getRepository(BasDePage::class);
            $info = $repository->find($parameter);

            if (empty($info)) {
                $output = array(
                    "status" => "erreur",
                    "message" => "Bas de page non disponible !"
                );
            } else {

                $info->setDeleted(true);
                try {
                    $em->persist($info);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Bas de page supprimé avec success !"
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