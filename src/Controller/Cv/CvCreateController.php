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
        PersonalInformationRepository $personalInformationRepository,
        CustomFieldInformationRepository $customFieldInformationRepository,
        CurriculumRepository $curriculumRepository,
        SluggerInterface $slugger,
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
            } else if (empty($data["ListeLanguage"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs skill ! ',
                    'status' => 'error'
                );
            } else if (empty($data["CenterOfInterest"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs Centre d\'interet ! ',
                    'status' => 'error'
                );
            } else if (empty($data["Reference"])) {
                $output = array(
                    'message' => 'Merci de remplir les champs Reference ! ',
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
                    empty($request->request->get("Name")) || empty($request->request->get("FirstName")) || empty($request->request->get("Email")) ||
                    empty($request->request->get("Telephone")) || empty($request->request->get("Address"))
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
                    empty($data["ListeLanguage"]['note_language']) || empty($data["ListeLanguage"]['id_language'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ de Language svp !',
                        'status' => 'error'
                    );
                } else if (
                    empty($data["Reference"]['name']) || empty($data["Reference"]['company']) || empty($data["Reference"]['city']) || empty($data["Reference"]['phone'])
                    || empty($data["Reference"]['mail'])
                ) {
                    $output = array(
                        'message' => 'Veuiller remplir tous les champ de Reference svp !',
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

                    $cv = new Curriculum();

                    // ======================================== Information =========================================

                    $str = $request->request->get("Email");
                    $pattern = "/@/i";

                    $date = date('Y-m-d');
                    if (preg_match($pattern, $str) === 1) {
                        $info = new PersonalInformation();


                        $info->setName($request->request->get("Name"));
                        $info->setFirstName($request->request->get("FirstName"));
                        $info->setEmail($request->request->get("Email"));
                        $info->setTelephone($request->request->get("Telephone"));
                        $info->setAddress($request->request->get("Address"));
                        $info->setPostalCode($request->request->get("PostalCode"));
                        $info->setCity($request->request->get("City"));
                        $info->setSexe($request->request->get("Sexe"));
                        $info->setNationality($request->request->get("Nationality"));
                        $info->setMaritalStatus($request->request->get("MartialStatus"));
                        $info->setIsDeleted(false);



                        $brochureFile = $request->files->get('file');


                        if ($brochureFile) {
                            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                            // this is needed to safely include the file name as part of the URL
                            $safeFilename = $slugger->slug($originalFilename);
                            $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();


                            try {
                                $brochureFile->move(
                                    $this->getParameter('brochures_directory'),
                                    $newFilename
                                );
                            } catch (FileException $e) {
                                // ... handle exception if something happens during file upload
                            }

                            $info->setPhoto($newFilename);

                            $info->setPath($this->getParameter('brochures_directory'));
                        }




                        $info->setPosition($request->request->get("Position"));
                        $info->setDatenaiss(\DateTime::createFromFormat('Y-m-d', $request->request->get("DateOfBirth")));
                        $info->setLieudenaiss($request->request->get("PlaceOfBirth"));
                        $info->setDriverLicense($request->request->get("DriverLicense"));



                        $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                        // $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));



                        $entityManager->persist($info);
                        $entityManager->flush();

                        $output = array(
                            'message' => 'Liste des Informations créer avec succés',

                            'status' => 'success'
                        );
                    } else {
                        $output = array(
                            'message' => 'Email non valide',
                            'status' => 'error'
                        );
                    }

                    // ======================================== PROFIL =========================================

                    $info = new Profil();
                    $date = date('Y-m-d');

                    $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $data["Profil"]["id_cv"]]);

                    $array = [];

                    foreach ($val as $infos) {
                        $info->setIdCv($infos);


                        $array[] = $info;
                    }

                    $info->setDescription($data["Profil"]['description']);

                    $info->setIsDeleted(false);

                    $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->persist($info);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Profil ajouter avec succès',
                        'status' => 'success'
                    );


                    // ======================================== Formation =========================================

                    

                    $formation = new Formation();

                    $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $data["Formation"]["id_cv"]]);

                    $array = [];

                    foreach ($val as $infos) {
                        $formation->setIdCv($infos);


                        $array[] = $formation;
                    }
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
                    // $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


                    $entityManager->persist($formation);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Formation créé avec succès',
                        'status' => 'success'
                    );

                    // ======================================== EXPERIENCE =========================================


                    

                    $experience = new ProfessionalExperience();

                    $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $data["Experience"]["id_cv"]]);

                    $array = [];

                    foreach ($val as $infos) {
                        $experience->setIdCv($infos);


                        $array[] = $experience;
                    }

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
                    // $experience->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


                    $entityManager->persist($experience);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Experience créer avec succés',
                        'status' => 'success'
                    );


                    // ======================================== SKILL =========================================


                    $skill = new Skill();
                    $date = date('Y-m-d');

                    $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $data["Skill"]["id_cv"]]);



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




                    $listeLanguage = new ListLanguage();

                    $val = $entityManager->getRepository(Language::class)->findBy(['id' => $data["ListeLanguage"]["id_language"]]);

                    $array = [];

                    foreach ($val as $infos) {
                        $listeLanguage->setIdLanguage($infos);


                        $array[] = $listeLanguage;
                    }


                    $id_cv = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $data["ListeLanguage"]["id_cv"]]);

                    $array = [];

                    foreach ($id_cv as $infos) {
                        $listeLanguage->setIdCv($infos);


                        $array[] = $listeLanguage;
                    }
                    $listeLanguage->setNoteLanguage($data["ListeLanguage"]['note_language']);


                    $listeLanguage->setDeleted(false);





                    $listeLanguage->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $listeLanguage->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


                    $entityManager->persist($formation);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Liste Language créer avec succés',
                        'status' => 'success'
                    );


                    // ======================================== Center of INTEREST =========================================


                    

                    $centerofinterest = new CenterOfInterest();
                    $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $data["CenterOfInterest"]["id_cv"]]);

                    $array = [];

                    foreach ($val as $infos) {
                        $centerofinterest->setIdCv($infos);


                        $array[] = $centerofinterest;
                    }

                    $centerofinterest->setDescription($data["CenterOfInterest"]['description']);

                    $centerofinterest->setIsDeleted(false);
        
                    $centerofinterest->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $centerofinterest->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));
        
                    $entityManager->persist($centerofinterest);
                    $entityManager->flush();

                    $output = array(
                        'message' => 'Centre d\'interet Créer avec succés',
                        'status' => 'success'
                    );



                    // ======================================== Reference =========================================



                    $str = $data["Reference"]['mail'];
                    $pattern = "/@/i";


                    if (preg_match($pattern, $str) === 1) {
                        $reference = new Reference();

                        $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $data["Reference"]["id_cv"]]);



                        foreach ($val as $references) {
                            $reference->setIdCv($references);
                        }

                        $reference->setName($data["Reference"]['name']);
                        $reference->setCompany($data["Reference"]['company']);
                        $reference->setCity($data["Reference"]['city']);
                        $reference->setPhone($data["Reference"]['phone']);
                        $reference->setMail($data["Reference"]['mail']);

                        $reference->setDeleted(false);


                        $reference->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                        // $reference->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $data["Reference"]['updatedAt']));



                        $entityManager->persist($reference);
                        $entityManager->flush();

                        $output = array(
                            'message' => 'Reference créer avec succés',
                            'status' => 'success'
                        );
                    } else {
                        $output = array(
                            'message' => 'Email non valide',
                            'status' => 'error'
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
                        'data' => $info->getId(),
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