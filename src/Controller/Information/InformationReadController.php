<?php

namespace App\Controller\Information;

use App\Entity\PersonalInformation;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationReadController extends AbstractController
{
    /**
     * @Route("/information/information/read", name="app_information_information_read")
     */
    public function index(
        Request $request,
        PersonalInformationRepository $info,
        EntityManagerInterface $entityManager
    ): JsonResponse {

        $parametersAsArray = [];

        $val = $entityManager->getRepository(PersonalInformation::class)->findAll();

        $array = [];

        foreach ($val as $infos) {
            $val["name"] = $infos->getName();
            $val["first_name"] = $infos->getFirstName();
            $val["email"] = $infos->getEmail();
            $val["profil_title"] = $infos->getProfilTitle();
            $val["telephone"] = $infos->getTelephone();
            $val["address"] = $infos->getAddress();
            $val["postal_code"] = $infos->getPostalCode();
            $val["city"] = $infos->getCity();
            $val["sexe"] = $infos->getSexe();
            $val["nationality"] = $infos->getNationality();
            $val["marital_status"] = $infos->getMaritalStatus();
            $val["is_deleted"] = $infos->isIsDeleted();
            $val["createdAt"] = $infos->getCreatedAt();
            $val["updatedAt"] = $infos->getUpdatedAt();

            $array[] = $val;
        }




        return $this->json([
            'message' => 'La liste des Information',
            'data' => $array,
            'status' => 'success'
        ]);
    }
}
