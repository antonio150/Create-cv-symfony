<?php

namespace App\Controller\Cv;

use App\Entity\BasDePage;
use App\Entity\CenterOfInterest;
use App\Entity\Curriculum;
use App\Entity\Formation;
use App\Entity\Language;
use App\Entity\ListLanguage;
use App\Entity\PersonalInformation;
use App\Entity\ProfessionalExperience;
use App\Entity\ProfessionalTraining;
use App\Entity\Profil;
use App\Entity\Reference;
use App\Entity\Skill;
use App\Entity\Utilisateur;
use App\Repository\CurriculumRepository;
use App\Repository\CustomFieldInformationRepository;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CvCreateController extends AbstractController
{
    /**
     * @Route("/api/v1/cv/create", name="app_cv_create")
     */
    public function curriculum(
       
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
            } else if (empty($data["Skill"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs skill ! ',
                    'status' => 'error'
                );
            } else if (empty($data["BasDePage"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs Bas de page ! ',
                    'status' => 'error'
                );
            } else if (empty($data["Training"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs Training ! ',
                    'status' => 'error'
                );
            } else {

              
                if (
                    empty($data["Skill"]['skill']) || empty($data["Skill"]['level'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ de Skill svp!!!',
                        'status' => 'error'
                    );
                } else  if (
                    empty($data["Training"]['position']) || empty($data["Training"]['employer']) || empty($data["Training"]['city']) ||
                    empty($data["Training"]['month_start']) || empty($data["Training"]['year_start']) || empty($data["Training"]['month_end']) || empty($data["Training"]['year_end'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ de Training svp !',
                        'status' => 'error'
                    );
                } else {
                    $date = date('Y-m-d');
                    $idCV = $data["Id"];

                   


                    // ======================================== PROFIL =========================================

                    $profil = new Profil();
                    $date = date('Y-m-d');

                    $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $idCV]);
                    // dd($val);
                    $array = [];

                    

                    foreach ($val as $profils) {
                        $profil->setIdCv($profils);
                        $array[] = $profil;
                    }
                    $profil->setDescription($data["Profil"]['description']);
                    $profil->setIsDeleted(false);
                    $profil->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->persist($profil);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Profil ajouter avec succès',
                        'status' => 'success'
                    );


                    // ======================================== Formation =========================================

                    $countNBFormation = count($data["Formation"]);

                    if ($countNBFormation === 0) {
                        return $this->json([
                            'message' => 'Le champ est vide',
                            'status' => 'error'
                        ]);
                    } else {

                        foreach ($data["Formation"] as $formationJson) {


                            $date = date('Y-m-d');

                            $formation = new Formation();

                            $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $idCV]);

                            $array = [];

                            foreach ($val as $infos) {
                                $formation->setIdCv($infos);


                                $array[] = $formation;
                            }
                            $formation->setTraining($formationJson['training']);
                            $formation->setEstablishment($formationJson['establishment']);
                            $formation->setCity($formationJson['city']);
                            $formation->setMonthStart($formationJson['month_start']);
                            $formation->setYearStart($formationJson['year_start']);
                            $formation->setMonthEnd($formationJson['month_end']);
                            $formation->setYearEnd($formationJson['year_end']);
                            $formation->setThisDay($formationJson['this_day']);
                            $formation->setDeleted(false);

                            $formation->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                            // $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $formationJson['updatedAt']));



                            $entityManager->persist($formation);
                            $entityManager->flush();
                        }
                        $output = array(
                            'message' => 'Formation créé avec succès',
                            'status' => 'success'
                        );
                    }

                    // ======================================== EXPERIENCE =========================================




                    $countNBExperience = count($data["Experience"]);


                    if ($countNBExperience === 0) {
                        $output = array(
                            'message' => 'Le champ est vide',
                            'status' => 'error'
                        );
                    } else {

                        foreach ($data["Experience"] as $experienceJson) {
                            $date = date('Y-m-d');

                            $experience = new ProfessionalExperience();

                            $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $idCV]);

                            $array = [];

                            foreach ($val as $infos) {
                                $experience->setIdCv($infos);


                                $array[] = $experience;
                            }

                            $experience->setJob($experienceJson['job']);
                            $experience->setCompany($experienceJson['company']);
                            $experience->setCity($experienceJson['city']);
                            $experience->setMonthStart($experienceJson['month_start']);
                            $experience->setYearStart($experienceJson['year_start']);
                            $experience->setMonthEnd($experienceJson['month_end']);
                            $experience->setYearEnd($experienceJson['year_end']);
                            $experience->setThisDay($experienceJson['this_day']);
                            $experience->setIsDeleted(false);





                            $experience->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                            // $experience->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $experienceJson['updatedAt']));


                            $entityManager->persist($experience);
                            $entityManager->flush();
                        }
                        $output = array(
                            'message' => 'Experience créer avec succés',
                            'status' => 'success'
                        );
                    }

                    // ======================================== SKILL =========================================


                    $skill = new Skill();
                    $date = date('Y-m-d');

                    $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $idCV]);



                    foreach ($val as $references) {
                        $skill->setIdCv($references);
                    }

                    $skill->setSkill($data["Skill"]['skill']);
                    $skill->setLevel($data["Skill"]['level']);
                    $skill->setIsDeleted(false);

                    $skill->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $skill->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));

                    $entityManager->persist($skill);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Skill créer avec succés',
                        'status' => 'success'
                    );



                    // ======================================== Liste LANGUAGE =========================================




                    $countNBlistlanguage = count($data["ListeLanguage"]);


                    if ($countNBlistlanguage === 0) {
                        $output = array(
                            'message' => 'Le champ est vide',
                            'status' => 'error'
                        );
                    } else {

                        foreach ($data["ListeLanguage"] as $listlanguageJson) {

                            if (
                                empty($listlanguageJson['note_language']) || empty($listlanguageJson['id_language'])
                            ) {
                                $output = array(
                                    'message' => 'Veuiller remplir tous les champ svp !',
                                    'status' => 'error'
                                );
                            } else {

                                $date = date('Y-m-d');

                                $listlanguage = new ListLanguage();

                                $val = $entityManager->getRepository(Language::class)->findBy(['id' => $listlanguageJson["id_language"]]);

                                $array = [];

                                foreach ($val as $infos) {
                                    $listlanguage->setIdLanguage($infos);
                                }


                                $id_cv = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $idCV]);

                                $array = [];

                                foreach ($id_cv as $infos) {
                                    $listlanguage->setIdCv($infos);
                                }
                                $listlanguage->setNoteLanguage($listlanguageJson['note_language']);


                                $listlanguage->setDeleted(false);


                                $listlanguage->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                                // $listlanguage->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $listlanguageJson['updatedAt']));


                                $entityManager->persist($listlanguage);
                                $entityManager->flush();
                            }
                        }
                        $output = array(
                            'message' => 'Formation créer avec succés',
                            'status' => 'success'
                        );
                    }


                    // ======================================== Center of INTEREST =========================================




                    $countNBcenterofinterest = count($data["CenterOfInterest"]);


                    if ($countNBcenterofinterest === 0) {
                        $output = array(
                            'message' => 'Le champ est vide',
                            'status' => 'error'
                        );
                    } else {

                        foreach ($data["CenterOfInterest"] as $centerofinterestJson) {


                            $date = date('Y-m-d');

                            $centerofinterest = new CenterOfInterest();
                            $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $idCV]);

                            $array = [];
                            // dd($val);

                            $centerofinterest->setIdCv($val);
                          

                            $centerofinterest->setDescription($centerofinterestJson['description']);

                            $centerofinterest->setIsDeleted(false);




                            $centerofinterest->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                            // $centerofinterest->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $centerofinterestJson['updatedAt']));



                            $entityManager->persist($centerofinterest);
                            $entityManager->flush();
                        }
                        $output = array(
                            'message' => 'Centre d\'interet Créer avec succés',
                            'status' => 'success'
                        );
                    }



                    // ======================================== Reference =========================================



                    $countNBReference = count($data["Reference"]);


                    if ($countNBReference === 0) {
                        $output = array(
                            'message' => 'Le champ est vide',
                            'status' => 'error'
                        );
                    } else {

                        foreach ($data["Reference"] as $referenceJson) {
                            if (
                                empty($referenceJson['name']) || empty($referenceJson['company']) || empty($referenceJson['city']) ||
                                empty($referenceJson['phone']) || empty($referenceJson['mail'])
                            ) {
                                $output = array(
                                    'message' => 'Veuiller remplir tous les champ svp !',
                                    'status' => 'error'
                                );
                            } else {
                                $str = $referenceJson['mail'];
                                $pattern = "/@/i";

                                $date = date('Y-m-d');
                                if (preg_match($pattern, $str) === 1) {
                                    $reference = new Reference();

                                    $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $idCV]);



                                    foreach ($val as $references) {
                                        $reference->setIdCv($references);
                                    }

                                    $reference->setName($referenceJson['name']);
                                    $reference->setCompany($referenceJson['company']);
                                    $reference->setCity($referenceJson['city']);
                                    $reference->setPhone($referenceJson['phone']);
                                    $reference->setMail($referenceJson['mail']);

                                    $reference->setDeleted(false);


                                    $reference->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                                    // $reference->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $referenceJson['updatedAt']));



                                    $entityManager->persist($reference);
                                    $entityManager->flush();
                                } else {
                                    $output = array(
                                        'message' => 'Email non valide',
                                        'status' => 'error'
                                    );
                                }
                            }
                        }
                        $output = array(
                            'message' => 'Reference créer avec succés',
                            'status' => 'success'
                        );
                    }

                    // ======================================== Bas de page =========================================




                    $basdepage = new BasDePage();

                    $basdepage->setDescription($data["BasDePage"]['description']);

                    $basdepage->setDeleted(false);




                    $basdepage->setCreatedAt(\DateTime::createFromFormat(
                        'Y-m-d',
                        $date
                    ));
                    // $basdepage->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data['updatedAt']));



                    $entityManager->persist($basdepage);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Bas de page Créer avec success',
                        'status' => 'success'
                    );




                    // ======================================== Training =========================================





                    $training = new ProfessionalTraining();

                    $training->setPosition($data["Training"]['position']);
                    $training->setEmployer($data["Training"]['employer']);
                    $training->setCity($data["Training"]['city']);
                    $training->setMonthStart($data["Training"]['month_start']);
                    $training->setYearStart($data["Training"]['year_start']);
                    $training->setMonthEnd($data["Training"]['month_end']);
                    $training->setYearEnd($data["Training"]['year_end']);
                    $training->setThisDay($data["Training"]['this_day']);
                    $training->setisDeleted(false);

                    $training->setCreatedAt(\DateTime::createFromFormat(
                        'Y-m-d',
                        $date
                    ));
                    // $training->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data['updatedAt']));


                    $entityManager->persist($training);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Training Créer avec success',
                        'status' => 'success'
                    );




                    // ======================================== UPDATE CV =========================================
                    // ======================================== UPDATE CV =========================================

                    // echo ($_GET["name"]);

                    $valcv = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $idCV]);
                    $valuser = $entityManager->getRepository(Utilisateur::class)->findOneBy(['id' => $data["Id_user"]]);
                    $valprofil = $entityManager->getRepository(Profil::class)->findOneBy(['id' => $profil->getId()]);
                    $valbasdepage = $entityManager->getRepository(BasDePage::class)->findOneBy(['id' => $basdepage->getId()]);
                    $valtraining = $entityManager->getRepository(ProfessionalTraining::class)->findOneBy(['id' => $training->getId()]);
                    // dd($profil->getId());
                    $array = [];


                    $valcv->setIdProfil($valprofil);
                    $valcv->setIdUser($valuser);
                    $valcv->setIdBasDePage($valbasdepage);
                    $valcv->setIdTraining($valtraining);

                    // $entityManager->persist($valcv);
                    $entityManager->flush();
                }
            }



        }
        return $this->json([
            "output" => $output
        ]);
    }
}