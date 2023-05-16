<?php

namespace App\Controller\Information;

use App\Entity\PersonalInformation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationUpdateController extends AbstractController
{
    /**
     * @Route("/information/information/update", name="app_information_information_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): JsonResponse {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }


        $info = $entityManager->getRepository(PersonalInformation::class)->find($parametersAsArray["id"]);

        $info->setName($parametersAsArray["name"]);
        $info->setFirstName($parametersAsArray["first_name"]);
        $info->setEmail($parametersAsArray["email"]);
        $info->setProfilTitle($parametersAsArray["profil_title"]);
        $info->setTelephone($parametersAsArray["telephone"]);
        $info->setAddress($parametersAsArray["address"]);
        $info->setPostalCode($parametersAsArray["postal_code"]);
        $info->setCity($parametersAsArray["city"]);
        $info->setSexe($parametersAsArray["sexe"]);
        $info->setNationality($parametersAsArray["nationality"]);
        $info->setMaritalStatus($parametersAsArray["marital_status"]);
        $info->setIsDeleted($parametersAsArray["is_deleted"]);
        $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
        $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));

        $entityManager->flush();

        return $this->json([
            'message' => 'Champ modifier',
            'status' => 'succes'
        ]);
    }
}
