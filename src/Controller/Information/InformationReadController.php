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




        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(PersonalInformation::class);
        $data = $repository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["name"] = $item->getName();
            $temp["first_name"] = $item->getFirstName();
            $temp["email"] = $item->getEmail();
            $temp["telephone"] = $item->getTelephone();
            $temp["address"] = $item->getAddress();
            $temp["postal_code"] = $item->getPostalCode();
            $temp["city"] = $item->getCity();
            $temp["sexe"] = $item->getSexe();
            $temp["nationality"] = $item->getNationality();
            $temp["marital_status"] = $item->getMaritalStatus();
            $temp["photo"] = $item->getPhoto();
            $temp["path"] = $item->getPath();
            $temp["position"] = $item->getPosition();
            $temp["datenaiss"] = $item->getDatenaiss();
            $temp["lieudenaiss"] = $item->getLieudenaiss();
            $temp["driver_license"] = $item->getDriverLicense();

            $temp["createdAt"] = $item->getCreatedAt();
            $temp["updatedAt"] = $item->getUpdatedAt();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des utilisateurs',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}