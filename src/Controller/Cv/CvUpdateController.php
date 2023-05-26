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

        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }


        // ======================================== PROFIL =========================================



        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            if (empty($parametersAsArray["id"])) {
                return $this->json([
                    'message' => 'Id non definie !',
                    'status' => 'error'
                ]);
            } else {
                $date = date('Y-m-d');

                $profil = $entityManager->getRepository(Profil::class)->find($parametersAsArray["id"]);

                $profil->setDescription($parametersAsArray['description']);
                // $profil->setCurriculum($parametersAsArray['curriculum']);

                // $profil->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                $profil->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                $entityManager->flush();

                return $this->json([
                    'message' => 'Profil modifié avec succès',
                    'status' => 'success'
                ]);
            }
        }


        // ======================================== Formation =========================================








        $countNB = count($parametersAsArray);


        if ($countNB === 0) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            foreach ($parametersAsArray as $formationJson) {


                $date = date('Y-m-d');



                if (empty($formationJson["id"])) {
                    return $this->json([
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
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
            return $this->json([
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            ]);
        }


        // ======================================== EXPERIENCE =========================================


        $countNB = count($parametersAsArray);


        if ($countNB === 0) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            foreach ($parametersAsArray as $experienceJson) {


                $date = date('Y-m-d');



                if (empty($experienceJson["id"])) {
                    return $this->json([
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
            return $this->json([
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            ]);
        }



        // ======================================== SKILL =========================================



        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {
            if (
                empty($parametersAsArray['skill']) || empty($parametersAsArray['level'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {


                $date = date('Y-m-d');


                if (empty($parametersAsArray["id"])) {
                    return $this->json([
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
                } else {

                    $skill = $entityManager->getRepository(Skill::class)->find($parametersAsArray["id"]);

                    $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $parametersAsArray["id_cv"]]);


                    $skill->setIdCv($val);

                    $skill->setSkill($parametersAsArray['skill']);
                    $skill->setLevel($parametersAsArray['level']);

                    $skill->setIsDeleted(false);


                    // $skill->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                    $skill->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    return $this->json([
                        'message' => 'Modification effectué avec succès',
                        'status' => 'success'
                    ]);
                }
            }
        }


        // ======================================== Liste LANGUAGE =========================================



        $countNB = count($parametersAsArray);


        if ($countNB === 0) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            foreach ($parametersAsArray as $listlanguageJson) {
                if (
                    empty($listlanguageJson['note_language']) || empty($listlanguageJson['id_language'])
                ) {
                    return $this->json([
                        'message' => 'Veuiller remplir tous les champ svp !',
                        'status' => 'error'
                    ]);
                } else {


                    $date = date('Y-m-d');



                    if (empty($listlanguageJson["id"])) {
                        return $this->json([
                            'message' => 'Id non definie !',
                            'status' => 'error'
                        ]);
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
            return $this->json([
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            ]);
        }


        // ======================================== Center of INTEREST =========================================


        $countNB = count($parametersAsArray);


        if ($countNB === 0) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            foreach ($parametersAsArray as $centerofinterestJson) {

                $date = date('Y-m-d');


                if (empty($centerofinterestJson["id"])) {
                    return $this->json([
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
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
                return $this->json([
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                ]);
            }
        }



        // ======================================== Reference =========================================


        $countNB = count($parametersAsArray);


        if ($countNB === 0) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            foreach ($parametersAsArray as $referenceJson) {
                if (
                    empty($referenceJson['name']) || empty($referenceJson['company']) || empty($referenceJson['city']) ||
                    empty($referenceJson['phone']) || empty($referenceJson['mail'])
                ) {
                    return $this->json([
                        'message' => 'Veuiller remplir tous les champ svp !',
                        'status' => 'error'
                    ]);
                } else {

                    $str = $referenceJson['mail'];
                    $pattern = "/@/i";
                    $date = date('Y-m-d');

                    if (preg_match($pattern, $str) === 1) {

                        if (empty($referenceJson["id"])) {
                            return $this->json([
                                'message' => 'Id non definie !',
                                'status' => 'error'
                            ]);
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
                        return $this->json([
                            'message' => 'Mail non valide',
                            'status' => 'error'
                        ]);
                    }
                }
            }
            return $this->json([
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            ]);
        }



        // ======================================== Bas de page =========================================


        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            $date = date('Y-m-d');


            if (empty($parametersAsArray["id"])) {
                return $this->json([
                    'message' => 'Id non definie !',
                    'status' => 'error'
                ]);
            } else {

                $basdepage = $entityManager->getRepository(BasDePage::class)->find($parametersAsArray["id"]);

                $basdepage->setDescription($parametersAsArray['description']);


                $basdepage->setDeleted(false);


                // $basdepage->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                $basdepage->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                $entityManager->flush();

                return $this->json([
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                ]);
            }
        }



        // ======================================== Training =========================================

        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {
            if (
                empty($parametersAsArray['position']) || empty($parametersAsArray['employer']) || empty($parametersAsArray['city']) ||
                empty($parametersAsArray['month_start']) || empty($parametersAsArray['year_start']) || empty($parametersAsArray['month_end']) || empty($parametersAsArray['year_end'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {


                $date = date('Y-m-d');



                if (empty($parametersAsArray["id"])) {
                    return $this->json([
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
                } else {
                    $training = $entityManager->getRepository(ProfessionalTraining::class)->find($parametersAsArray["id"]);


                    $training->setPosition($parametersAsArray['position']);
                    $training->setEmployer($parametersAsArray['employer']);
                    $training->setCity($parametersAsArray['city']);
                    $training->setMonthStart($parametersAsArray['month_start']);
                    $training->setYearStart($parametersAsArray['year_start']);
                    $training->setMonthEnd($parametersAsArray['month_end']);
                    $training->setYearEnd($parametersAsArray['year_end']);
                    $training->setThisDay($parametersAsArray['this_day']);

                    $training->setIsDeleted(false);



                    // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                    $training->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    return $this->json([
                        'message' => 'Modification effectué avec succès',
                        'status' => 'success'
                    ]);
                }
            }
        }
    }
}
