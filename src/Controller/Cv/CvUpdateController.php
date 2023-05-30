<?php

namespace App\Controller\Cv;

use App\Entity\BasDePage;
use App\Entity\CenterOfInterest;
use App\Entity\Curriculum;
use App\Entity\Formation;
use App\Entity\Language;
use App\Entity\ListLanguage;
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


        $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $_GET["id"]]);

        if ($val === null) {
            $output = array(
                'message' => 'Id non definie',
                'status' => 'error'
            );
        } else {
            $array = [];


            $valIdCv = $val->getId();
            $valpersonalInformation = $val->getPersonalInformation();
            $valid_profil = $val->getIdProfil();
            $valid_user = $val->getIdUser();
            $valid_formation = $val->getIdFormation();
            $valid_experience = $val->getIdExperience();
            $valid_interet = $val->getIdInteret();
            $valid_reference = $val->getIdReference();
            $valid_skill = $val->getIdSkill();
            $valid_langue = $val->getIdLangue();
            $valid_bas_de_page = $val->getIdBasDePage();
            $valid_training = $val->getIdTraining();




            // ======================================== PROFIL =========================================



            if (empty($data["Profil"])) {
                $output = array(
                    'message' => 'Le champ est vide',
                    'status' => 'error'
                );
            } else {

                if (empty($valid_profil)) {
                    $output = array(
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    );
                } else {
                    $date = date('Y-m-d');

                    $profil = $entityManager->getRepository(Profil::class)->find($valid_profil);

                    $profil->setDescription($data["Profil"]['description']);
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


            $countNB = count($data['Formation']);


            if ($countNB === 0) {
                $output = array(
                    'message' => 'Le champ est vide',
                    'status' => 'error'
                );
            } else {
                $formation = $entityManager->getRepository(Formation::class)->findBy(['id_cv' => $valIdCv]);
                foreach ($data['Formation'] as $formationJson) {
                    // dd($formation);

                    $date = date('Y-m-d');

                    foreach ($formation as $formations) {

                        if (empty($valIdCv)) {
                            $output = array(
                                'message' => 'Id non definie !',
                                'status' => 'error'
                            );
                        } else {

                            echo $formations->getId();
                            echo $formationJson['training'];
                            // dd($valIdCv);

                            // $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $valIdCv]);

                            // dd($formationJson['training']);
                            // $formation->setIdCv($val);

                            $formations->setTraining($formationJson['training']);
                            $formations->setEstablishment($formationJson['establishment']);
                            $formations->setCity($formationJson['city']);
                            $formations->setMonthStart($formationJson['month_start']);
                            $formations->setYearStart($formationJson['year_start']);
                            $formations->setMonthEnd($formationJson['month_end']);
                            $formations->setYearEnd($formationJson['year_end']);
                            $formations->setThisDay($formationJson['this_day']);

                            // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $formationJson['createdAt']));
                            $formations->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                            $entityManager->flush();
                        }
                        array_shift($formation);
                        break;
                    }
                }
                $output = array(
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                );
            }


            // ======================================== EXPERIENCE =========================================


            $countNB = count($data['Experience']);


            if ($countNB === 0) {
                $output = array(
                    'message' => 'Le champ est vide',
                    'status' => 'error'
                );
            } else {
                $experience = $entityManager->getRepository(ProfessionalExperience::class)->findBy(['id_cv' => $valIdCv]);
                foreach ($data['Experience'] as $experienceJson) {


                    $date = date('Y-m-d');

                    foreach ($experience as $experiences) {

                        if (empty($valIdCv)) {
                            $output = array([
                                'message' => 'Id non definie !',
                                'status' => 'error'
                            ]);
                        } else {



                            // $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $valIdCv]);


                            // $experience->setIdCv($val);
                            $experiences->setJob($experienceJson['job']);
                            $experiences->setCompany($experienceJson['company']);
                            $experiences->setCity($experienceJson['city']);
                            $experiences->setMonthStart($experienceJson['month_start']);
                            $experiences->setYearStart($experienceJson['year_start']);
                            $experiences->setMonthEnd($experienceJson['month_end']);
                            $experiences->setYearEnd($experienceJson['year_end']);
                            $experiences->setThisDay($experienceJson['this_day']);
                            $experiences->setIsDeleted(false);


                            // $experiences->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $experienceJson['createdAt']));
                            $experiences->setUpdatedAt(\DateTime::createFromFormat(
                                'Y-m-d',
                                $date
                            ));


                            $entityManager->flush();

                            array_shift($experience);
                            break;
                        }
                    }
                }
                $output = array(
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                );
            }



            // ======================================== SKILL =========================================



            if (empty($data['Skill'])) {
                $output = array(
                    'message' => 'Le champ est vide',
                    'status' => 'error'
                );
            } else {
                if (
                    empty($data['Skill']['skill']) || empty($data['Skill']['level'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ svp !',
                        'status' => 'error'
                    );
                } else {


                    $date = date('Y-m-d');


                    if (empty($valIdCv)) {
                        $output = array(
                            'message' => 'Id non definie !',
                            'status' => 'error'
                        );
                    } else {

                        $skill = $entityManager->getRepository(Skill::class)->findOneBy(['id_cv' => $valIdCv]);

                        // $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $valIdCv]);

                        // dd($skill);
                        // $skill->setIdCv($val);

                        $skill->setSkill($data['Skill']['skill']);
                        $skill->setLevel($data['Skill']['level']);

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



            $countNB = count($data['ListLanguage']);


            if ($countNB === 0) {
                $output = array(
                    'message' => 'Le champ est vide',
                    'status' => 'error'
                );
            } else {

                $listLanguage = $entityManager->getRepository(ListLanguage::class)->findBy(['id_cv' => $valIdCv]);

                foreach ($data['ListLanguage'] as $listlanguageJson) {
                    if (
                        empty($listlanguageJson['note_language']) || empty($listlanguageJson['id_language'])
                    ) {
                        $output = array(
                            'message' => 'Veuiller remplir tous les champ svp !',
                            'status' => 'error'
                        );
                    } else {


                        $date = date('Y-m-d');

                        foreach ($listLanguage as $listLanguages) {




                            if (empty($valIdCv)) {
                                $output = array(
                                    'message' => 'Id non definie !',
                                    'status' => 'error'
                                );
                            } else {



                                $val = $entityManager->getRepository(Language::class)->findOneBy(['id' => $listlanguageJson["id_language"]]);


                                $listLanguages->setIdLanguage($val);

                                // $id_cv = $entityManager->getRepository(Curriculum::class)->findOneBy(['id_cv' => $valIdCv]);

                                // $array = [];


                                // $listLanguage->setIdCv($id_cv);



                                $listLanguages->setNoteLanguage($listlanguageJson['note_language']);


                                $listLanguages->setDeleted(false);



                                // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $listlanguageJson['createdAt']));
                                $listLanguages->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                                $entityManager->flush();
                            }

                            array_shift($listLanguage);
                            break;
                        }
                    }
                }
                $output = array(
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                );
            }


            // ======================================== Center of INTEREST =========================================


            $countNB = count($data['CenterOfInterest']);
            // dd($countNB);

            if ($countNB === 0) {
                $output = array(
                    'message' => 'Le champ est vide',
                    'status' => 'error'
                );
            } else {
                $findCOI = [];
                $centerofinterest = $entityManager->getRepository(CenterOfInterest::class)->findBy(['id_cv' => $valIdCv]);
                $centerofinterestArr = $centerofinterest;





                foreach ($data['CenterOfInterest'] as $centerofinterestJson) {

                    foreach ($centerofinterestArr as $centerofinterests) {



                        $centerofinterests->setDescription($centerofinterestJson['description']);


                        $centerofinterests->setIsDeleted(false);


                        // $centerofinterest->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $centerofinterestJson['createdAt']));
                        $centerofinterests->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                        $entityManager->flush();

                        // break;

                        array_shift($centerofinterestArr);
                        break;
                    }
                   
                }
                $output = array(
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                );
            }



            // ======================================== Reference =========================================


            $countNB = count($data['Reference']);


            if ($countNB === 0) {
                $output = array(
                    'message' => 'Le champ est vide',
                    'status' => 'error'
                );
            } else {
                $reference = $entityManager->getRepository(Reference::class)->findBy(['id_cv' => $valIdCv]);

                foreach ($data['Reference'] as $referenceJson) {
                    foreach ($reference as $references) {
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



                            // $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $valIdCv]);
                           

                            // $reference->setIdCv($val);

                            $references->setName($referenceJson['name']);
                            $references->setCompany($referenceJson['company']);
                            $references->setCity($referenceJson['city']);
                            $references->setPhone($referenceJson['phone']);
                            $references->setMail($referenceJson['mail']);

                            $references->setDeleted(false);


                            // $reference->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $referenceJson['createdAt']));
                            $references->setUpdatedAt(\DateTime::createFromFormat(
                                'Y-m-d',
                                $date
                            ));

                            $entityManager->flush();
                                
                          
                        }
                        array_shift($reference);
                        break;
                    }
                }
                $output = array(
                    'message' => 'Modification effectué avec succès',
                    'status' => 'success'
                );
            }



            // ======================================== Bas de page =========================================


            if (empty($data['BasDePage'])) {
                $output = array(
                    'message' => 'Le champ est vide',
                    'status' => 'error'
                );
            } else {

                $date = date('Y-m-d');


                if (empty($valid_bas_de_page)) {
                    $output = array(
                        'message' => 'Id non definie !',
                        'status' => 'error'
                    );
                } else {

                    $basdepage = $entityManager->getRepository(BasDePage::class)->find($valid_bas_de_page);

                    $basdepage->setDescription($data['BasDePage']['description']);


                    $basdepage->setDeleted(false);


                    // $basdepage->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $data['createdAt']));
                    $basdepage->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    $output = array(
                        'message' => 'Modification effectué avec succès',
                        'status' => 'success'
                    );
                }
            }



            // ======================================== Training =========================================

            if (empty($data['Training'])) {
                $output = array(
                    'message' => 'Le champ est vide',
                    'status' => 'error'
                );
            } else {
                if (
                    empty($data['Training']['position']) || empty($data['Training']['employer']) || empty($data['Training']['city']) ||
                    empty($data['Training']['month_start']) || empty($data['Training']['year_start']) || empty($data['Training']['month_end']) ||
                    empty($data['Training']['year_end'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ svp !',
                        'status' => 'error'
                    );
                } else {


                    $date = date('Y-m-d');



                    if (empty($valid_training)) {
                        $output = array(
                            'message' => 'Id non definie !',
                            'status' => 'error'
                        );
                    } else {
                        $training = $entityManager->getRepository(ProfessionalTraining::class)->find($valid_training);


                        $training->setPosition($data['Training']['position']);
                        $training->setEmployer($data['Training']['employer']);
                        $training->setCity($data['Training']['city']);
                        $training->setMonthStart($data['Training']['month_start']);
                        $training->setYearStart($data['Training']['year_start']);
                        $training->setMonthEnd($data['Training']['month_end']);
                        $training->setYearEnd($data['Training']['year_end']);
                        $training->setThisDay($data['Training']['this_day']);

                        $training->setIsDeleted(false);



                        // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $data['createdAt']));
                        $training->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                        $entityManager->flush();

                        $output = array(
                            'message' => 'Modification effectué avec succès',
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
}