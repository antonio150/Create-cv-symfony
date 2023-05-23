<?php

namespace App\Controller\Skill;

use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillDeleteController extends AbstractController
{
    /**
     * @Route("/skill/skill/delete", name="app_skill_skill_delete")
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
                "status" => "error",
                "message" => "Données introuvable, merci de contacter l'administrateur !"
            );
        } else {
            $parameter = array(
                "id" => $data["id"]
            );
            $repository = $em->getRepository(Skill::class);
            $info = $repository->find($parameter);

            if (empty($info)) {
                $output = array(
                    "status" => "error",
                    "message" => "Langage non definie !"
                );
            } else {

                $info->setIsDeleted(true);
                try {
                    $em->persist($info);
                    $em->flush();
                    $output = array(
                        "status" => "success",
                        "message" => "Skill supprimer with success !"
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