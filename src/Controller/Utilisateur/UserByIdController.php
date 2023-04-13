<?php

namespace App\Controller\Utilisateur;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserByIdController extends AbstractController
{
    /**
     * @Route("/api/v1/user/by/id", name="app_user_by_id")
     */
    public function getInfo(UtilisateurRepository $utilisateurRepository): JsonResponse
    {
        $output = array();
        $temp = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        $dataQuery = $utilisateurRepository->findBy(['id' => $data["id"]]);

        if (empty($dataQuery)) {
            $output = array(
                'message' => 'Utilisateur introuvable ! ',
                'status' => 'erreur'
            );
        } 

        foreach ($dataQuery as $item) {
            $temp["id"] = $item->getId();
            $temp["name"] = $item->getName();
            $temp["firstName"] = $item->getFirstName();
            $temp["type"] = $item->getUserType()->getId();
            $temp["adresse"] = $item->getAdresse();
            $temp["roles"] = $item->getRoles();
            $temp["username"] = $item->getUsername();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Info Utilisateur',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
