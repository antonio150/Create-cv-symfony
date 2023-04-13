<?php

namespace App\Controller\Utilisateur;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurListController extends AbstractController
{
    /**
     * @Route("api/v1/user/list", name="app_utilisateur_utilisateur_list")
     */
    public function list(): JsonResponse
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $data = $repository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["id"] = $item->getId();
            $temp["name"] = $item->getName();
            $temp["firstName"] = $item->getFirstName();
            $temp["type"] = $item->getUserType()->getType();
            $temp["adresse"] = $item->getAdresse();
            $temp["roles"] = $item->getRoles();
            $temp["username"] = $item->getUsername();
            $temp["status"] = $item->isIsBlocked();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des utilisateurs',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
