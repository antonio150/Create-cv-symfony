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

        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {
            if (
                empty($parametersAsArray['name']) || empty($parametersAsArray['first_name']) || empty($parametersAsArray['email']) || empty($parametersAsArray['profil_title']) ||
                empty($parametersAsArray['telephone']) || empty($parametersAsArray['address']) 
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {

                $str = $parametersAsArray['email'];
                $pattern = "/@/i";
                $date = date('Y-m-d');

                if (preg_match($pattern, $str) === 1) {

                    if (empty($parametersAsArray["id"])) {
                        return $this->json([
                            'message' => 'Id Undefined !',
                            'status' => 'error'
                        ]);
                    } else {

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
                        $info->setIsDeleted(false);
                    $info->setPhoto($parametersAsArray['photo']);
                    $info->setPath($parametersAsArray['path']);
                    $info->setPosition($parametersAsArray['position']);
                    $info->setDatenaiss(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['datenaiss']));
                    $info->setLieudenaiss($parametersAsArray['lieudenaiss']);
                    $info->setDriverLicense($parametersAsArray['driver_license']);


                    // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                    $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    return $this->json([
                        'message' => 'Champ modifier',
                        'status' => 'succes'
                    ]);
                    }
                } else {
                    return $this->json([
                        'message' => 'Mail non valide',
                        'status' => 'error'
                    ]);
                }
            }
        }
      

        
    }
}