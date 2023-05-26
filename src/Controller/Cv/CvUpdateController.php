<?php

namespace App\Controller\Cv;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvUpdateController extends AbstractController
{
    /**
     * @Route("/cv/cv/update", name="app_cv_cv_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        $data = [];
        if ($content = $request->getContent()) {
            $data = json_decode($content, true);
        }


        // ======================================== PROFIL =========================================



        if (empty($data)) {
            $output = array(
                'message' => 'Le champ est vide',
                'status' => 'error'
            );
        } else {

            if (empty($data["id"])) {
                $output = array(
                    'message' => 'Id non definie !',
                    'status' => 'error'
                );
            } else {
                $date = date('Y-m-d');

                $profil = $entityManager->getRepository(Profil::class)->find($data["id"]);

                $profil->setDescription($data['description']);
                // $profil->setCurriculum($data['curriculum']);

                // $profil->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $data['createdAt']));
                $profil->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                $entityManager->flush();

                $output = array(
                    'message' => 'Profil modifié avec succès',
                    'status' => 'success'
                );
            }
        }


        // ======================================== Formation =========================================








        $countNB = count($data);


        if ($countNB === 0) {
            $output = array(
                'message' => 'Le champ est vide',
                'status' => 'error'
            );
        } else {

            foreach ($data as $formationJson) {


                $date = date('Y-m-d');



                if (empty($formationJson["id"])) {
                    $output = array(
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    );
                } else {
                    $formation = $entityManager->getRepository(Formation::class)->find($formationJson["id"]);
                    $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $formationJson["id_cv"]]);

                    $formation->setIdCv($val);

                    $formation->setTraining($formationJson['training']);
                    $formation->setEstablishment($formationJson['establishment']);
                    $formation->setCity($formationJson['city']);
                    $formation->setMonthStart($formationJson['month_start']);
                    $formation->setYearStart($formationJson['year_start']);
                    $formation->setMonthEnd($formationJson['month_end']);
                    $formation->setYearEnd($formationJson['year_end']);
                    $formation->setThisDay($formationJson['this_day']);



                    // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $formationJson['createdAt']));
                    $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();
                }
            }
            $output = array(
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            );
        }


        // ======================================== EXPERIENCE =========================================


        $countNB = count($data);


        if ($countNB === 0) {
            $output = array(
                'message' => 'Le champ est vide',
                'status' => 'error'
            );
        } else {

            foreach ($data as $experienceJson) {


                $date = date('Y-m-d');



                if (empty($experienceJson["id"])) {
                    $output = array([
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
                } else {

                    $experience = $entityManager->getRepository(ProfessionalExperience::class)->find($experienceJson["id"]);
                    $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $experienceJson["id_cv"]]);

                    $array = [];


                    $experience->setIdCv($val);
                    $experience->setJob($experienceJson['job']);
                    $experience->setCompany($experienceJson['company']);
                    $experience->setCity($experienceJson['city']);
                    $experience->setMonthStart($experienceJson['month_start']);
                    $experience->setYearStart($experienceJson['year_start']);
                    $experience->setMonthEnd($experienceJson['month_end']);
                    $experience->setYearEnd($experienceJson['year_end']);
                    $experience->setThisDay($experienceJson['this_day']);
                    $experience->setIsDeleted(false);


                    // $experience->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $experienceJson['createdAt']));
                    $experience->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));


                    $entityManager->flush();
                }
            }
            $output = array(
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            );
        }



        // ======================================== SKILL =========================================



        if (empty($data)) {
            $output = array(
                'message' => 'Le champ est vide',
                'status' => 'error'
            );
        } else {
            if (
                empty($data['skill']) || empty($data['level'])
            ) {
                $output = array(
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                );
            } else {


                $date = date('Y-m-d');


                if (empty($data["id"])) {
                    $output = array(
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    );
                } else {

                    $skill = $entityManager->getRepository(Skill::class)->find($data["id"]);

                    $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $data["id_cv"]]);


                    $skill->setIdCv($val);

                    $skill->setSkill($data['skill']);
                    $skill->setLevel($data['level']);

                    $skill->setIsDeleted(false);


                    // $skill->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $data['createdAt']));
                    $skill->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    $output = array(
                        'message' => 'Modification effectué avec succès',
                        'status' => 'success'
                    );
                }
            }
        }


        // ======================================== Liste LANGUAGE =========================================



        $countNB = count($data);


        if ($countNB === 0) {
            $output = array(
                'message' => 'Le champ est vide',
                'status' => 'error'
            );
        } else {

            foreach ($data as $listlanguageJson) {
                if (
                    empty($listlanguageJson['note_language']) || empty($listlanguageJson['id_language'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ svp !',
                        'status' => 'error'
                    );
                } else {


                    $date = date('Y-m-d');



                    if (empty($listlanguageJson["id"])) {
                        $output = array(
                            'message' => 'Id non definie !',
                            'status' => 'error'
                        );
                    } else {
                        $formation = $entityManager->getRepository(ListLanguage::class)->findOneBy(["id" => $listlanguageJson["id"]]);


                        $val = $entityManager->getRepository(Language::class)->findOneBy(['id' => $listlanguageJson["id_language"]]);

                        $array = [];


                        $formation->setIdLanguage($val);

                        $id_cv = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $listlanguageJson["id_cv"]]);

                        $array = [];


                        $formation->setIdCv($id_cv);



                        $formation->setNoteLanguage($listlanguageJson['note_language']);


                        $formation->setDeleted(false);



                        // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $listlanguageJson['createdAt']));
                        $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                        $entityManager->flush();
                    }
                }
            }
            $output = array(
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            );
        }


        // ======================================== Center of INTEREST =========================================


        $countNB = count($data);


        if ($countNB === 0) {
            $output = array(
                'message' => 'Le champ est vide',
                'status' => 'error'
            );
        } else {

            foreach ($data as $centerofinterestJson) {

                $date = date('Y-m-d');


                if (empty($centerofinterestJson["id"])) {
                    $output = array(
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    );
                } else {

                    $centerofinterest = $entityManager->getRepository(CenterOfInterest::class)->find($centerofinterestJson["id"]);
                    $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $centerofinterestJson["id_cv"]]);

                    $array = [];


                    $centerofinterest->setIdCv($val);

                    $centerofinterest->setDescription($centerofinterestJson['description']);


                    $centerofinterest->setIsDeleted(false);


                    // $centerofinterest->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $centerofinterestJson['createdAt']));
                    $centerofinterest->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();
                }
                $output = array(
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                );
            }
        }



        // ======================================== Reference =========================================


        $countNB = count($data);


        if ($countNB === 0) {
            $output = array(
                'message' => 'Le champ est vide',
                'status' => 'error'
            );
        } else {

            foreach ($data as $referenceJson) {
                if (
                    empty($referenceJson['name']) || empty($referenceJson['company']) || empty($referenceJson['city']) ||
                    empty($referenceJson['phone']) || empty($referenceJson['mail'])
                ) {
                    $output = array([
                        'message' => 'Veuiller remplir tous les champ svp !',
                        'status' => 'error'
                    ]);
                } else {

                    $str = $referenceJson['mail'];
                    $pattern = "/@/i";
                    $date = date('Y-m-d');

                    if (preg_match($pattern, $str) === 1) {

                        if (empty($referenceJson["id"])) {
                            $output = array(
                                'message' => 'Id non definie !',
                                'status' => 'error'
                            );
                        } else {

                            $info = $entityManager->getRepository(Reference::class)->find($referenceJson["id"]);
                            $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $referenceJson["id_cv"]]);

                            $array = [];


                            $info->setIdCv($val);

                            $info->setName($referenceJson['name']);
                            $info->setCompany($referenceJson['company']);
                            $info->setCity($referenceJson['city']);
                            $info->setPhone($referenceJson['phone']);
                            $info->setMail($referenceJson['mail']);

                            $info->setDeleted(false);


                            // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $referenceJson['createdAt']));
                            $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                            $entityManager->flush();
                        }
                    } else {
                        $output = array([
                            'message' => 'Mail non valide',
                            'status' => 'error'
                        ]);
                    }
                }
            }
            $output = array([
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            ]);
        }



        // ======================================== Bas de page =========================================


        if (empty($data)) {
            $output = array([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            $date = date('Y-m-d');


            if (empty($data["id"])) {
                $output = array([
                    'message' => 'Id non definie !',
                    'status' => 'error'
                ]);
            } else {

                $basdepage = $entityManager->getRepository(BasDePage::class)->find($data["id"]);

                $basdepage->setDescription($data['description']);


                $basdepage->setDeleted(false);


                // $basdepage->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $data['createdAt']));
                $basdepage->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                $entityManager->flush();

                $output = array([
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                ]);
            }
        }



        // ======================================== Training =========================================

        if (empty($data)) {
            $output = array([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {
            if (
                empty($data['position']) || empty($data['employer']) || empty($data['city']) ||
                empty($data['month_start']) || empty($data['year_start']) || empty($data['month_end']) || empty($data['year_end'])
            ) {
                $output = array([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {


                $date = date('Y-m-d');



                if (empty($data["id"])) {
                    $output = array([
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
                } else {
                    $training = $entityManager->getRepository(ProfessionalTraining::class)->find($data["id"]);


                    $training->setPosition($data['position']);
                    $training->setEmployer($data['employer']);
                    $training->setCity($data['city']);
                    $training->setMonthStart($data['month_start']);
                    $training->setYearStart($data['year_start']);
                    $training->setMonthEnd($data['month_end']);
                    $training->setYearEnd($data['year_end']);
                    $training->setThisDay($data['this_day']);

                    $training->setIsDeleted(false);



                    // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $data['createdAt']));
                    $training->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    $output = array([
                        'message' => 'Modification effectué avec succès',
                        'status' => 'success'
                    ]);
                }
            }
        }
        return $this->json([
            "output" => $output
        ]);
    }
}