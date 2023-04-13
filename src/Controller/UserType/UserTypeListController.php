<?php

namespace App\Controller\UserType;

use App\Repository\UserTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserTypeListController extends AbstractController
{
    /**
     * @Route("/api/v1/user/type/list", name="app_user_type_list")
     */
    public function list(UserTypeRepository $userTypeRepository): JsonResponse
    {
        $output = array();
        $temp = array();
        $data = $userTypeRepository->findAll();

        foreach ($data as $item) {
            $temp["id"] = $item->getId();
            $temp["type"] = $item->getType();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Valeur possible pour le type utilisateur',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
