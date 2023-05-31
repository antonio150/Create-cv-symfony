<?php

namespace App\Controller\Cv;

use App\Entity\BasDePage;
use App\Entity\CenterOfInterest;
use App\Entity\Curriculum;
use App\Entity\Formation;
use App\Entity\ListLanguage;
use App\Entity\PersonalInformation;
use App\Entity\ProfessionalExperience;
use App\Entity\ProfessionalTraining;
use App\Entity\Profil;
use App\Entity\Reference;
use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvByIdController extends AbstractController
{
    /**
     * @Route("/cv/cv/by/id", name="app_cv_cv_by_id")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        $output = array();
        $temp = array();
        $data = json_decode($request->getContent(), true);
        $valCV = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $data["id"]]);

        foreach ($valCV as $Curriculums) {


            $valIdCv = $Curriculums->getId();
            $valpersonalInformation = $Curriculums->getPersonalInformation();
            $valid_profil = $Curriculums->getIdProfil();



            $valid_bas_de_page = $Curriculums->getIdBasDePage();
            $valid_training = $Curriculums->getIdTraining();

            if (!empty($valid_profil) && !empty($valid_bas_de_page) && !empty($valid_training) && !empty($valpersonalInformation)) {



                $repository = $this->getDoctrine()->getRepository(PersonalInformation::class);
                $data = $repository->findBy(['id' => $valpersonalInformation]);

                foreach ($data as $item) {
                    $temp['Information']["name"] = $item->getName();
                    $temp['Information']["first_name"] = $item->getFirstName();
                    $temp['Information']["email"] = $item->getEmail();
                    $temp['Information']["telephone"] = $item->getTelephone();
                    $temp['Information']["address"] = $item->getAddress();
                    $temp['Information']["postal_code"] = $item->getPostalCode();
                    $temp['Information']["city"] = $item->getCity();
                    $temp['Information']["sexe"] = $item->getSexe();
                    $temp['Information']["nationality"] = $item->getNationality();
                    $temp['Information']["marital_status"] = $item->getMaritalStatus();
                    $temp['Information']["photo"] = $item->getPhoto();
                    $temp['Information']["path"] = $item->getPath();
                    $temp['Information']["position"] = $item->getPosition();
                    $temp['Information']["datenaiss"] = $item->getDatenaiss();
                    $temp['Information']["lieudenaiss"] = $item->getLieudenaiss();
                    $temp['Information']["driver_license"] = $item->getDriverLicense();

                    // $temp["createdAt"] = $item->getCreatedAt();
                    // $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }

                // dd($valid_profil);



                // ======================================== PROFIL =========================================


                $repository = $this->getDoctrine()->getRepository(Profil::class);
                $data = $repository->findBy(['id' => $valid_profil]);

                foreach ($data as $item) {
                    $temp['Profil']["id"] = $item->getId();
                    $temp['Profil']["description"] = $item->getDescription();
                    // $temp["curriculum"] = $item->getgetCurriculum();

                    array_push($output, $temp);
                }



                // ======================================== Formation =========================================

                $repository = $this->getDoctrine()->getRepository(Formation::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);



                foreach ($data as $item) {
                    $temp['Formation']["id_cv"] = $item->getIdCv();
                    $temp['Formation']["training"] = $item->getTraining();
                    $temp['Formation']["establishment"] = $item->getEstablishment();
                    $temp['Formation']["city"] = $item->getCity();
                    $temp['Formation']["month_start"] = $item->getMonthStart();
                    $temp['Formation']["year_start"] = $item->getYearStart();
                    $temp['Formation']["month_end"] = $item->getMonthEnd();
                    $temp['Formation']["year_end"] = $item->getYearEnd();
                    $temp['Formation']["this_day"] = $item->isThisDay();
                    $temp['Formation']["description"] = $item->getDescription();

                    // $temp["createdAt"] = $item->getCreatedAt();
                    // $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }

                // ======================================== EXPERIENCE =========================================

                $repository = $this->getDoctrine()->getRepository(ProfessionalExperience::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp['Experience']["id_cv"] = $item->getIdCv();
                    $temp['Experience']["job"] = $item->getJob();
                    $temp['Experience']["company"] = $item->getCompany();
                    $temp['Experience']["city"] = $item->getCity();
                    $temp['Experience']["month_start"] = $item->getMonthStart();
                    $temp['Experience']["year_start"] = $item->getYearStart();
                    $temp['Experience']["month_end"] = $item->getMonthEnd();
                    $temp['Experience']["year_end"] = $item->getYearEnd();
                    $temp['Experience']["this_day"] = $item->isThisDay();
                    $temp['Experience']["description"] = $item->getDescription();
                    array_push($output, $temp);
                }


                // ======================================== SKILL =========================================

                $repository = $this->getDoctrine()->getRepository(Skill::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp['Skill']["id_cv"] = $item->getIdCv();
                    $temp['Skill']["skill"] = $item->getSkill();
                    $temp['Skill']["level"] = $item->getLevel();


                    // $temp["createdAt"] = $item->getCreatedAt();
                    // $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }


                // ======================================== Liste LANGUAGE =========================================

                $repository = $this->getDoctrine()->getRepository(ListLanguage::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp['ListLanguage']["id_cv"] = $item->getIdCv();
                    $temp['ListLanguage']["id_language"] = $item->getIdLanguage();
                    $temp['ListLanguage']["note_language"] = $item->getNoteLanguage();

                    // $temp["createdAt"] = $item->getCreatedAt();
                    // $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }


                // ======================================== Center of INTEREST =========================================


                $repository = $this->getDoctrine()->getRepository(CenterOfInterest::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp['CenterOfInterest']["id_cv"] = $item->getIdCv();
                    $temp['CenterOfInterest']["description"] = $item->getDescription();


                    // $temp["createdAt"] = $item->getCreatedAt();
                    // $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }


                // ======================================== Reference =========================================

                $repository = $this->getDoctrine()->getRepository(Reference::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp['Reference']["id_cv"] = $item->getIdCv();
                    $temp['Reference']["name"] = $item->getName();
                    $temp['Reference']["company"] = $item->getCompany();
                    $temp['Reference']["city"] = $item->getCity();
                    $temp['Reference']["phone"] = $item->getPhone();
                    $temp['Reference']["mail"] = $item->getMail();

                    // $temp["createdAt"] = $item->getCreatedAt();
                    // $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }

                // ======================================== Bas de page =========================================

                $repository = $this->getDoctrine()->getRepository(BasDePage::class);
                $data = $repository->findBy(['id' => $valid_bas_de_page]);

                foreach ($data as $item) {
                    $temp['BasDePage']["description"] = $item->getDescription();


                    // $temp["createdAt"] = $item->getCreatedAt();
                    // $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }

                // ======================================== Training =========================================

                $repository = $this->getDoctrine()->getRepository(ProfessionalTraining::class);
                $data = $repository->findBy(['id' => $valid_training]);

                foreach ($data as $item) {
                    $temp['Training']["position"] = $item->getPosition();
                    $temp['Training']["employer"] = $item->getEmployer();
                    $temp['Training']["city"] = $item->getCity();
                    $temp['Training']["month_start"] = $item->getMonthStart();
                    $temp['Training']["year_start"] = $item->getYearStart();
                    $temp['Training']["month_end"] = $item->getMonthEnd();
                    $temp['Training']["year_end"] = $item->getYearEnd();
                    $temp['Training']["this_day"] = $item->isThisDay();
                    $temp['Training']["description"] = $item->getDescription();

                    // $temp["createdAt"] = $item->getCreatedAt();
                    // $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }
            }
        }
        return $this->json([
            'message' => 'Liste des CV',
            'data' => end($output),
            'status' => 'success'
        ]);
    }
}