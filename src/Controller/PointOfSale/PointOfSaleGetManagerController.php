<?php

namespace App\Controller\PointOfSale;

use App\Entity\UserType;
use App\Repository\UserTypeRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PointOfSaleGetManagerController extends AbstractController
{
    /**
     * @Route("/api/v1/point/of/sale/get/manager", name="app_point_of_sale_get_manager")
     */
    public function manager(UtilisateurRepository $utilisateurRepository, UserTypeRepository $userTypeRepository): JsonResponse
    {
        $idType = 3;
        $userType = $userTypeRepository->find($idType);
        $manager = $utilisateurRepository->findBy(['is_deleted' => false, 'user_type' => $idType], array('id' => 'DESC'));
        
        $output = array();

        foreach ($manager as $item) {
            $temp = array();
            $temp["id"] = $item->getId();
            $temp["name"] = $item->getName();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des manager de point de ventes',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
