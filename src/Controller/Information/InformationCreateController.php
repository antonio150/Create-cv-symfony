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

class InformationCreateController extends AbstractController
{
    /**
     * @Route("/information/information/create", name="app_information_information_create")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {
            if (
                empty($parametersAsArray['name']) || empty($parametersAsArray['first_name']) || empty($parametersAsArray['email']) || empty($parametersAsArray['profil_title']) ||
                empty($parametersAsArray['telephone']) || empty($parametersAsArray['address']) || empty($parametersAsArray['postal_code']) || empty($parametersAsArray['city']) ||
                empty($parametersAsArray['sexe']) || empty($parametersAsArray['nationality']) || empty($parametersAsArray['marital_status']) ||
                empty($parametersAsArray['is_deleted']) || empty($parametersAsArray['createdAt']) || empty($parametersAsArray['updatedAt'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {
                $info = new PersonalInformation();
                $vals = $info->getId();
                $info->setName($parametersAsArray['name']);
                $info->setFirstName($parametersAsArray['first_name']);
                $info->setEmail($parametersAsArray['email']);
                $info->setProfilTitle($parametersAsArray['profil_title']);
                $info->setTelephone($parametersAsArray['telephone']);
                $info->setAddress($parametersAsArray['address']);
                $info->setPostalCode($parametersAsArray['postal_code']);
                $info->setCity($parametersAsArray['city']);
                $info->setSexe($parametersAsArray['sexe']);
                $info->setNationality($parametersAsArray['nationality']);
                $info->setMaritalStatus($parametersAsArray['marital_status']);
                $info->setIsDeleted($parametersAsArray['is_deleted']);
                $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));



                $entityManager->persist($info);
                $entityManager->flush();

                return $this->json([
                    'message' => 'La liste des Information Créer',
                    'data' => $vals,
                    'status' => 'success'
                ]);
            }
        }
    }
}
