<?php

namespace App\Controller\Utilisateur;

use App\Entity\Utilisateur;
use App\Repository\UserTypeRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurUpdateController extends AbstractController
{
    /**
     * @Route("/api/v1/user/update", name="app_user_update")
     */
    public function update(UserTypeRepository $userTypeRepository): JsonResponse
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Utilisateur::class);

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error'
            );
        } else {
            if (empty($data["id"]) || empty($data["username"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {

                $id = isset($data["id"]) ? $data["id"] : NULL;
                if (!empty($id)) {
                    $param = array(
                        "id" => $data["id"]
                    );
                    $user = $repository->find($param);
                    if (empty($user)) {
                        $output = array(
                            "status" => "erreur",
                            "message" => "Utilisateur introuvable dans le système !"
                        );
                    } else {
                        $userType = $userTypeRepository->find($data["userType"]);
                        $user->setBaseAttributes($data, $userType);
                        try {
                            $em->persist($user);
                            $em->flush();
                            $output = array(
                                "status" => "success",
                                "message" => "Modification terminée avec succès !"
                            );
                        } catch (Exception $ex) {
                            $output = array(
                                "status" => "error",
                                "message" => $ex->getMessage()
                            );
                        }
                    }
                }
            }
        }

        return $this->json($output);
    }
}
