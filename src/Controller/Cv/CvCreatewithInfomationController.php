<?php

namespace App\Controller\Cv;

use App\Entity\Curriculum;
use App\Entity\PersonalInformation;
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

class CvCreatewithInfomationController extends AbstractController
{
    /**
     * @Route("/cv/cv/createwith/infomation", name="app_cv_cv_createwith_infomation")
     */
    public function index(

        Request $request,
        SluggerInterface $slugger,

        EntityManagerInterface $entityManager
    ): Response {
        // ======================================== Information =========================================

        $str = $request->request->get("Email");
        $pattern = "/@/i";

        $date = date('Y-m-d');

        $date = date('Y-m-d');
        $cv = new Curriculum();

        $cv->setDeleted(false);
        $cv->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
        // $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));

        $entityManager->persist($cv);
        $entityManager->flush();

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


            // ======================================== UPDATE CV =========================================
            // ======================================== UPDATE CV =========================================

            // echo ($_GET["name"]);
            $valcv = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $cv->getId()]);
            $valinfo = $entityManager->getRepository(PersonalInformation::class)->findOneBy(['id' => $info->getId()]);
            // dd($profil->getId());
            $array = [];



            $valcv->setPersonalInformation($valinfo);

            // $entityManager->persist($valcv);
            $entityManager->flush();

            $output = array(
                'message' => 'Liste des Informations créer avec succés',
                'id' => $cv->getId(),
                'status' => 'success'
            );
        } else {
            $output = array(
                'message' => 'Email non valide',
                'status' => 'error'
            );
        }
        return $this->json([
            "output" => $output
        ]);
    }
}