<?php

namespace App\Controller\Cv;

use App\Repository\CurriculumRepository;
use App\Repository\CustomFieldInformationRepository;
use App\Repository\PersonalInformationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/cv/create", name="app_cv_create")
     */
    public function curriculum(
        PersonalInformationRepository $personalInformationRepository, 
        CustomFieldInformationRepository $customFieldInformationRepository, 
        CurriculumRepository $curriculumRepository
    ): Response
    {

        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);
        $output = array();

        if (empty($data)) {
            $output = array(
                'message' => 'Les données envoyées sont vides ! ',
                'status' => 'error',
                'data' => $data
            );
        } else {
            // Verification des champs obligatoires 
            if (empty($data["personalInfo"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs obligatoires ! ',
                    'status' => 'error'
                );
            } else {
                // foreach ($data["personalInfo"] as $value) {
                    $name = $data["personalInfo"]["name"];
                    $firstName = $data["personalInfo"]["firstName"];
                    $email = $data["personalInfo"]["email"];
                    $profilTitle = $data["personalInfo"]["profilTitle"];
                    $telephone = $data["personalInfo"]["telephone"];
                    $address = $data["personalInfo"]["address"];
                    $postalCode = $data["personalInfo"]["postalCode"];
                    $city = $data["personalInfo"]["city"];
                    $sexe = $data["personalInfo"]["sexe"];
                    $nationality = $data["personalInfo"]["nationality"];
                    $maritalStatus = $data["personalInfo"]["maritalStatus"];
                // }
            }
        }
        return $this->render('cv/cv_create/index.html.twig', [
            'controller_name' => 'CvCreateController',
        ]);
    }
}
