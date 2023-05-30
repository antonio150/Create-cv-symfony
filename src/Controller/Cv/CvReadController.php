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
        $temp = array();

        $valCV = $entityManager->getRepository(Curriculum::class)->findBy(['deleted' => false]);

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

                    // $temp["createdAt"] = $item->getCreatedAt();
                    // $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }

                // dd($valid_profil);



                // ======================================== PROFIL =========================================


                $repository = $this->getDoctrine()->getRepository(Profil::class);
                $data = $repository->findBy(['id' => $valid_profil]);

                foreach ($data as $item) {
                    $temp["id"] = $item->getId();
                    $temp["description"] = $item->getDescription();
                    // $temp["curriculum"] = $item->getgetCurriculum();

                    array_push($output, $temp);
                }



                // ======================================== Formation =========================================

                $repository = $this->getDoctrine()->getRepository(Formation::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);



                foreach ($data as $item) {
                    $temp["id_cv"] = $item->getIdCv();
                    $temp["training"] = $item->getTraining();
                    $temp["establishment"] = $item->getEstablishment();
                    $temp["city"] = $item->getCity();
                    $temp["month_start"] = $item->getMonthStart();
                    $temp["year_start"] = $item->getYearStart();
                    $temp["month_end"] = $item->getMonthEnd();
                    $temp["year_end"] = $item->getYearEnd();
                    $temp["this_day"] = $item->isThisDay();
                    $temp["description"] = $item->getDescription();

                    $temp["createdAt"] = $item->getCreatedAt();
                    $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }

                // ======================================== EXPERIENCE =========================================

                $repository = $this->getDoctrine()->getRepository(ProfessionalExperience::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp["id_cv"] = $item->getIdCv();
                    $temp["job"] = $item->getJob();
                    $temp["company"] = $item->getCompany();
                    $temp["city"] = $item->getCity();
                    $temp["month_start"] = $item->getMonthStart();
                    $temp["year_start"] = $item->getYearStart();
                    $temp["month_end"] = $item->getMonthEnd();
                    $temp["year_end"] = $item->getYearEnd();
                    $temp["this_day"] = $item->isThisDay();
                    $temp["description"] = $item->getDescription();
                    array_push($output, $temp);
                }


                // ======================================== SKILL =========================================

                $repository = $this->getDoctrine()->getRepository(Skill::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp["id_cv"] = $item->getIdCv();
                    $temp["skill"] = $item->getSkill();
                    $temp["level"] = $item->getLevel();


                    $temp["createdAt"] = $item->getCreatedAt();
                    $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }


                // ======================================== Liste LANGUAGE =========================================

                $repository = $this->getDoctrine()->getRepository(ListLanguage::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp["id_cv"] = $item->getIdCv();
                    $temp["id_language"] = $item->getIdLanguage();
                    $temp["note_language"] = $item->getNoteLanguage();

                    $temp["createdAt"] = $item->getCreatedAt();
                    $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }


                // ======================================== Center of INTEREST =========================================


                $repository = $this->getDoctrine()->getRepository(CenterOfInterest::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp["id_cv"] = $item->getIdCv();
                    $temp["description"] = $item->getDescription();


                    $temp["createdAt"] = $item->getCreatedAt();
                    $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }


                // ======================================== Reference =========================================

                $repository = $this->getDoctrine()->getRepository(Reference::class);
                $data = $repository->findBy(['id_cv' => $valIdCv]);

                foreach ($data as $item) {
                    $temp["id_cv"] = $item->getIdCv();
                    $temp["name"] = $item->getName();
                    $temp["company"] = $item->getCompany();
                    $temp["city"] = $item->getCity();
                    $temp["phone"] = $item->getPhone();
                    $temp["mail"] = $item->getMail();

                    $temp["createdAt"] = $item->getCreatedAt();
                    $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }

                // ======================================== Bas de page =========================================

                $repository = $this->getDoctrine()->getRepository(BasDePage::class);
                $data = $repository->findBy(['id' => $valid_bas_de_page]);

                foreach ($data as $item) {
                    $temp["description"] = $item->getDescription();


                    $temp["createdAt"] = $item->getCreatedAt();
                    $temp["updatedAt"] = $item->getUpdatedAt();
                    array_push($output, $temp);
                }

                // ======================================== Training =========================================

                $repository = $this->getDoctrine()->getRepository(ProfessionalTraining::class);
                $data = $repository->findBy(['id' => $valid_training]);

                foreach ($data as $item) {
                    $temp["position"] = $item->getPosition();
                    $temp["employer"] = $item->getEmployer();
                    $temp["city"] = $item->getCity();
                    $temp["month_start"] = $item->getMonthStart();
                    $temp["year_start"] = $item->getYearStart();
                    $temp["month_end"] = $item->getMonthEnd();
                    $temp["year_end"] = $item->getYearEnd();
                    $temp["this_day"] = $item->isThisDay();
                    $temp["description"] = $item->getDescription();

                    $temp["createdAt"] = $item->getCreatedAt();
                    $temp["updatedAt"] = $item->getUpdatedAt();
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
