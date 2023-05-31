<?php

namespace App\Controller\Cv;

use App\Controller\Information\InformationReadController;
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


use App\Controller\Profil\ProfilReadController;


class CvReadController extends AbstractController
{
    /**
     * @Route("/cv/cv/read", name="app_cv_cv_read")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        $output = array();
        $outputFormation['Formation'] = array();
        $outputExperience['Experience'] = array();
        $outputListlanguage['ListLanguage'] = array();
        $outputCenterofinterest = array();
        $outputReference = array();
        $temp = array();
        $tempInformation = array();
        $tempProfil = array();
        $tempFormation = array();
        $tempExperience = array();
        $tempSkill = array();
        $tempListlanguage = array();
        $outputCenterofinterest['CenterOfInterest'] = array();
        $outputReference['Reference'] = array();
        $tempBasdepage = array();
        $tempTraining = array();

        $valCV = $entityManager->getRepository(Curriculum::class)->findBy(['deleted' => false]);
        $outputFinal = array();
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
                    $tempInformation['Information']["name"] = $item->getName();
                    $tempInformation['Information']["first_name"] = $item->getFirstName();
                    $tempInformation['Information']["email"] = $item->getEmail();
                    $tempInformation['Information']["telephone"] = $item->getTelephone();
                    $tempInformation['Information']["address"] = $item->getAddress();
                    $tempInformation['Information']["postal_code"] = $item->getPostalCode();
                    $tempInformation['Information']["city"] = $item->getCity();
                    $tempInformation['Information']["sexe"] = $item->getSexe();
                    $tempInformation['Information']["nationality"] = $item->getNationality();
                    $tempInformation['Information']["marital_status"] = $item->getMaritalStatus();
                    $tempInformation['Information']["photo"] = $item->getPhoto();
                    $tempInformation['Information']["path"] = $item->getPath();
                    $tempInformation['Information']["position"] = $item->getPosition();
                    $tempInformation['Information']["datenaiss"] = $item->getDatenaiss();
                    $tempInformation['Information']["lieudenaiss"] = $item->getLieudenaiss();
                    $tempInformation['Information']["driver_license"] = $item->getDriverLicense();

                    // $tempInformation["createdAt"] = $item->getCreatedAt();
                    // $tempInformation["updatedAt"] = $item->getUpdatedAt();
                    
                }

                // require '../Information/InformationReadController.php';
                // $informationContr = new InformationReadController();
                // echo ($informationContr->readInformation());

                $informationData = $this->forward('App\Controller\Information\InformationReadController::readInformation')->getContent();
                $informationData1 = str_replace('\"', '"', $informationData);
                // $informationData = str_replace(, "", $informationData);
                array_push($output, $informationData1);
                // dd($valid_profil);



                // ======================================== PROFIL =========================================


                $repository = $this->getDoctrine()->getRepository(Profil::class);
                $data = $repository->findBy(['id' => $valid_profil]);

                foreach ($data as $item) {
                    $tempProfil['Profil']["id"] = $item->getId();
                    $tempProfil['Profil']["description"] = $item->getDescription();
                    // $tempProfil["curriculum"] = $item->getgetCurriculum();

                    
                }
                // $profilData = new ProfilReadController;
                // dd($profilData->indexProfil());

                $profilData = $this->forward('App\Controller\Profil\ProfilReadController::readProfil')->getContent();
                array_push($output, $profilData);


                // ======================================== Formation =========================================

                $repository = $this->getDoctrine()->getRepository(Formation::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);



                foreach ($data as $item) {
                    $tempFormation["id_cv"] = $item->getIdCv();
                    $tempFormation["training"] = $item->getTraining();
                    $tempFormation["establishment"] = $item->getEstablishment();
                    $tempFormation["city"] = $item->getCity();
                    $tempFormation["month_start"] = $item->getMonthStart();
                    $tempFormation["year_start"] = $item->getYearStart();
                    $tempFormation["month_end"] = $item->getMonthEnd();
                    $tempFormation["year_end"] = $item->getYearEnd();
                    $tempFormation["this_day"] = $item->isThisDay();
                    $tempFormation["description"] = $item->getDescription();

                    // $tempFormation["createdAt"] = $item->getCreatedAt();
                    // $tempFormation["updatedAt"] = $item->getUpdatedAt();
                    array_push($outputFormation['Formation'], $tempFormation);
                }
                $formationData = $this->forward('App\Controller\Formation\FormationReadController::readFormation')->getContent();

                array_push($output, $formationData);

                // ======================================== EXPERIENCE =========================================

                $repository = $this->getDoctrine()->getRepository(ProfessionalExperience::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $tempExperience["id_cv"] = $item->getIdCv();
                    $tempExperience["job"] = $item->getJob();
                    $tempExperience["company"] = $item->getCompany();
                    $tempExperience["city"] = $item->getCity();
                    $tempExperience["month_start"] = $item->getMonthStart();
                    $tempExperience["year_start"] = $item->getYearStart();
                    $tempExperience["month_end"] = $item->getMonthEnd();
                    $tempExperience["year_end"] = $item->getYearEnd();
                    $tempExperience["this_day"] = $item->isThisDay();
                    $tempExperience["description"] = $item->getDescription();
                    array_push($outputExperience['Experience'], $tempExperience);
                }

                // dd($outputExperience);
                $experienceData = $this->forward('App\Controller\Experience\ExperienceReadController::readExperience')->getContent();
                array_push($output, $experienceData);

                // ======================================== SKILL =========================================

                $repository = $this->getDoctrine()->getRepository(Skill::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $tempSkill['Skill']["id_cv"] = $item->getIdCv();
                    $tempSkill['Skill']["skill"] = $item->getSkill();
                    $tempSkill['Skill']["level"] = $item->getLevel();


                    // $tempSkill["createdAt"] = $item->getCreatedAt();
                    // $tempSkill["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $tempSkill);
                }

                $skillData = $this->forward('App\Controller\Skill\SkillReadController::readSkill')->getContent();
                array_push($output, $skillData);

                // ======================================== Liste LANGUAGE =========================================

                $repository = $this->getDoctrine()->getRepository(ListLanguage::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $tempListlanguage["id_cv"] = $item->getIdCv();
                    $tempListlanguage["id_language"] = $item->getIdLanguage();
                    $tempListlanguage["note_language"] = $item->getNoteLanguage();

                    // $tempListlanguage["createdAt"] = $item->getCreatedAt();
                    // $tempListlanguage["updatedAt"] = $item->getUpdatedAt();
                    array_push($outputListlanguage['ListLanguage'], $tempListlanguage);
                }
                array_push($output, $outputListlanguage);

                // ======================================== Center of INTEREST =========================================


                $repository = $this->getDoctrine()->getRepository(CenterOfInterest::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $tempCenterofinterest["id_cv"] = $item->getIdCv();
                    $tempCenterofinterest["description"] = $item->getDescription();


                    // $tempCenterofinterest["createdAt"] = $item->getCreatedAt();
                    // $tempCenterofinterest["updatedAt"] = $item->getUpdatedAt();
                    array_push($outputCenterofinterest['CenterOfInterest'], $tempCenterofinterest);
                }
                array_push($output, $outputCenterofinterest);

                // ======================================== Reference =========================================

                $repository = $this->getDoctrine()->getRepository(Reference::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $tempReference["id_cv"] = $item->getIdCv();
                    $tempReference["name"] = $item->getName();
                    $tempReference["company"] = $item->getCompany();
                    $tempReference["city"] = $item->getCity();
                    $tempReference["phone"] = $item->getPhone();
                    $tempReference["mail"] = $item->getMail();

                    // $tempReference["createdAt"] = $item->getCreatedAt();
                    // $tempReference["updatedAt"] = $item->getUpdatedAt();
                    array_push($outputReference['Reference'], $tempReference);
                }
                array_push($output, $outputReference);
                // ======================================== Bas de page =========================================

                $repository = $this->getDoctrine()->getRepository(BasDePage::class);
                $data = $repository->findBy(['id' => $valid_bas_de_page]);

                foreach ($data as $item) {
                    $tempBasdepage['BasDePage']["description"] = $item->getDescription();


                    // $tempBasdepage["createdAt"] = $item->getCreatedAt();
                    // $tempBasdepage["updatedAt"] = $item->getUpdatedAt();
                    
                }
                array_push($output, $tempBasdepage);
                // ======================================== Training =========================================

                $repository = $this->getDoctrine()->getRepository(ProfessionalTraining::class);
                $data = $repository->findBy(['id' => $valid_training]);

                foreach ($data as $item) {
                    $tempTraining['Training']["position"] = $item->getPosition();
                    $tempTraining['Training']["employer"] = $item->getEmployer();
                    $tempTraining['Training']["city"] = $item->getCity();
                    $tempTraining['Training']["month_start"] = $item->getMonthStart();
                    $tempTraining['Training']["year_start"] = $item->getYearStart();
                    $tempTraining['Training']["month_end"] = $item->getMonthEnd();
                    $tempTraining['Training']["year_end"] = $item->getYearEnd();
                    $tempTraining['Training']["this_day"] = $item->isThisDay();
                    $tempTraining['Training']["description"] = $item->getDescription();

                    // $tempTraining["createdAt"] = $item->getCreatedAt();
                    // $tempTraining["updatedAt"] = $item->getUpdatedAt();
                   
                }
                array_push($output, $tempTraining);
            }

            if (end($output) !== false) {
                array_push($outputFinal, $output);
                // dd($outputFinal);
            }
        }

        return $this->json([
            'message' => 'Liste des CV',
            'data' => $outputFinal,
            'status' => 'success'
        ]);
    }
}