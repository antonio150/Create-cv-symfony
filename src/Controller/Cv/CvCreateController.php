<?php

namespace App\Controller\Cv;

use App\Entity\CenterOfInterest;
use App\Entity\Formation;
use App\Entity\Language;
use App\Entity\PersonalInformation;
use App\Entity\ProfessionalExperience;
use App\Entity\ProfessionalTraining;
use App\Entity\Profil;
use App\Entity\Skill;
use App\Repository\CurriculumRepository;
use App\Repository\CustomFieldInformationRepository;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        CurriculumRepository $curriculumRepository,
        EntityManagerInterface $entityManager
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
            if (empty($data["Profil"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs profil ! ',
                    'status' => 'error'
                );
            } else  if (empty($data["Formation"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs formation ! ',
                    'status' => 'error'
                );
            } else if (empty($data["Experience"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs experience ! ',
                    'status' => 'error'
                );
            } else if (empty($data["Skill"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs skill ! ',
                    'status' => 'error'
                );
            } else if (empty($data["Language"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs skill ! ',
                    'status' => 'error'
                );
            } else if (empty($data["Information"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs information ! ',
                    'status' => 'error'
                );
            } else if (empty($data["CenterOfInterest"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs information ! ',
                    'status' => 'error'
                );
            } else {

                if (
                    empty($data["Information"]['name']) || empty($data["Information"]['first_name']) || empty($data["Information"]['email']) ||
                    empty($data["Information"]['telephone']) || empty($data["Information"]['address'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ de Information svp !',
                        'status' => 'error'
                    );
                } else  if (
                    empty($data["Formation"]['training']) || empty($data["Formation"]['establishment']) || empty($data["Formation"]['city']) ||
                    empty($data["Formation"]['month_start']) || empty($data["Formation"]['year_start']) || empty($data["Formation"]['month_end']) || empty($data["Formation"]['year_end'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ de Formation svp !',
                        'status' => 'error'
                    );
                } else if (
                    empty($data["Experience"]['job']) || empty($data["Experience"]['company']) || empty($data["Experience"]['city']) ||
                    empty($data["Experience"]['month_start']) || empty($data["Experience"]['year_start']) || empty($data["Experience"]['month_end']) || empty($data["Experience"]['year_end'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ de Experience svp !',
                        'status' => 'error'
                    );
                } else if (
                    empty($data["Skill"]['skill']) || empty($data["Skill"]['level'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ de Skill svp!!!',
                        'status' => 'error'
                    );
                } else if (
                    empty($data["Language"]['language']) || empty($data["Language"]['level'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ de Language svp !',
                        'status' => 'error'
                    );
                } else {

                    // ======================================== Information =========================================

                    $str = $data["Information"]['email'];
                    $pattern = "/@/i";

                    $date = date('Y-m-d');
                    if (preg_match($pattern, $str) === 1) {


                        // foreach ($data["Information"] as $value) {

                        $date = date('Y-m-d');

                        $info = new PersonalInformation();

                        $info->setName($data["Information"]["name"]);
                        $info->setFirstName($data["Information"]["first_name"]);
                        $info->setEmail($data["Information"]["email"]);
                        $info->setTelephone($data["Information"]["telephone"]);
                        $info->setAddress($data["Information"]["address"]);
                        $info->setPostalCode($data["Information"]["postal_code"]);
                        $info->setCity($data["Information"]["city"]);
                        $info->setSexe($data["Information"]["sexe"]);
                        $info->setNationality($data["Information"]["nationality"]);
                        $info->setMaritalStatus($data["Information"]["marital_status"]);
                        $info->setIsDeleted(false);
                        $info->setPhoto($data["Information"]["photo"]);
                        $info->setPath($data["Information"]["path"]);
                        $info->setPosition($data["Information"]["position"]);
                        $info->setDatenaiss(\DateTime::createFromFormat('Y-m-d', $data["Information"]["datenaiss"]));
                        $info->setLieudenaiss($data["Information"]["lieudenaiss"]);
                        $info->setDriverLicense($data["Information"]["driver_license"]);



                        $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                        // $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data['updatedAt']));


                        $form = $data;
                        $vals = $info->getId();

                        $entityManager->persist($info);
                        $entityManager->flush();
                    }



                    // ======================================== PROFIL =========================================

                    $profil = new Profil();
                    $date = date('Y-m-d');

                    $profil->setDescription($data["Profil"]['description']);
                    // $profil->setCurriculum($data['curriculum']);
                    $profil->setIsDeleted(false);

                    $profil->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $profil->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data['updatedAt']));

                    $entityManager->persist($profil);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Ajout avec succes ',
                        'status' => 'success'
                    );


                    // ======================================== Formation =========================================

                    $date = date('Y-m-d');

                    $formation = new Formation();

                    $formation->setTraining($data["Formation"]['training']);
                    $formation->setEstablishment($data["Formation"]['establishment']);
                    $formation->setCity($data["Formation"]['city']);
                    $formation->setMonthStart($data["Formation"]['month_start']);
                    $formation->setYearStart($data["Formation"]['year_start']);
                    $formation->setMonthEnd($data["Formation"]['month_end']);
                    $formation->setYearEnd($data["Formation"]['year_end']);
                    $formation->setThisDay($data["Formation"]['this_day']);
                    $formation->setDeleted(false);





                    $formation->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data['updatedAt']));


                    $entityManager->persist($formation);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Ajout avec succes ',
                        'status' => 'success'
                    );


                    // ======================================== EXPERIENCE =========================================


                    $date = date('Y-m-d');

                    $experience = new ProfessionalExperience();

                    $experience->setJob($data["Experience"]['job']);
                    $experience->setCompany($data["Experience"]['company']);
                    $experience->setCity($data["Experience"]['city']);
                    $experience->setMonthStart($data["Experience"]['month_start']);
                    $experience->setYearStart($data["Experience"]['year_start']);
                    $experience->setMonthEnd($data["Experience"]['month_end']);
                    $experience->setYearEnd($data["Experience"]['year_end']);
                    $experience->setThisDay($data["Experience"]['this_day']);
                    $experience->setIsDeleted(false);





                    $experience->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $experience->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data['updatedAt']));


                    $entityManager->persist($experience);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Experience Créer',
                        'status' => 'success'
                    );


                    // ======================================== SKILL =========================================


                    $info = new Skill();
                    $date = date('Y-m-d');

                    $info->setSkill($data["Skill"]['skill']);
                    $info->setLevel($data["Skill"]['level']);
                    $info->setIsDeleted(false);

                    $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data['updatedAt']));

                    $entityManager->persist($info);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Skill Créer',
                        'status' => 'success'
                    );



                    // ======================================== LANGUAGE =========================================


                    $date = date('Y-m-d');

                    $lang = new Language();

                    $lang->setLanguage($data["Language"]['language']);
                    $lang->setLevel($data["Language"]['level']);

                    $lang->setIsDeleted(false);


                    $lang->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $lang->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data['updatedAt']));



                    $entityManager->persist($lang);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Language Créer',
                        'status' => 'success'
                    );


                    // ======================================== Center of INTEREST =========================================


                    $date = date('Y-m-d');

                    $centerofinterest = new CenterOfInterest();

                    $centerofinterest->setDescription($data["CenterOfInterest"]['description']);

                    $centerofinterest->setIsDeleted(false);




                    $centerofinterest->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $centerofinterest->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data['updatedAt']));


                    $form = $data;
                    $vals = $centerofinterest->getId();

                    $entityManager->persist($centerofinterest);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Centre d\'interet Créer',
                        'status' => 'success'
                    );
                }
            }



        }
        return $this->json([
            "output" => $output
        ]);
    }
}