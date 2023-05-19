<?php

namespace App\Controller\Information;

use App\Entity\PersonalInformation;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationGetByIdController extends AbstractController
{
    /**
     * @Route("/information/information/get/by/id", name="app_information_information_get_by_id")
     */
    public function index(
        Request $request,
        PersonalInformationRepository $info,
        EntityManagerInterface $entityManager
    ): Response {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        if (empty($parametersAsArray["id"])) {
            return $this->json([
                'message' => 'Id Information vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(PersonalInformation::class)->findBy(['id' => $parametersAsArray["id"]]);

            if ($val === null) {
                return $this->json([
                    'message' => 'Id undefined',
                    'status' => 'success'
                ]);
            } else {
                $array = [];

                foreach ($val as $infos) {
                    $val["name"] = $infos->getName();
                    $val["first_name"] = $infos->getFirstName();
                    $val["email"] = $infos->getEmail();
                    $val["telephone"] = $infos->getTelephone();
                    $val["address"] = $infos->getAddress();
                    $val["postal_code"] = $infos->getPostalCode();
                    $val["city"] = $infos->getCity();
                    $val["sexe"] = $infos->getSexe();
                    $val["nationality"] = $infos->getNationality();
                    $val["marital_status"] = $infos->getMaritalStatus();
                    $val["photo"] = $infos->getPhoto();
                    $val["path"] = $infos->getPath();
                    $val["position"] = $infos->getPosition();
                    $val["datenaiss"] = $infos->getDatenaiss();
                    $val["lieudenaiss"] = $infos->getLieudenaiss();
                    $val["driver_license"] = $infos->getDriverLicense();

                 

                    $array[] = $val;
                }




                return $this->json([
                    'message' => 'La liste des Information',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}