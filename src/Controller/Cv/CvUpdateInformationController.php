<?php

namespace App\Controller\Cv;

use App\Entity\Curriculum;
use App\Entity\PersonalInformation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CvUpdateInformationController extends AbstractController
{
    /**
     * @Route("/cv/cv/update/information", name="app_cv_cv_update_information")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request,
        SluggerInterface $slugger
    ): JsonResponse {

        $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $_GET["id"]]);

        if ($val === null) {
            $output = array(
                'message' => 'Id CV non definie',
                'status' => 'error'
            );
        } else {
            $array = [];


            $valIdCv = $val->getId();
            $valpersonalInformation = $val->getPersonalInformation();
            // dd($valpersonalInformation);

            if (
                empty($request->request->get("Name")) || empty($request->request->get("FirstName")) || empty($request->request->get("Email")) ||
                empty($request->request->get("Telephone")) || empty($request->request->get("Address"))
            ) {
                echo ($request->request->get("Name"));
                if (empty($request->request->get("Name"))) {
                    return $this->json([
                        'message' => 'Veuiller remplir name !',
                        'status' => 'error'
                    ]);
                } else if (empty($request->request->get("FirstName"))) {
                    return $this->json([
                        'message' => 'Veuiller remplir FirstName !',
                        'status' => 'error'
                    ]);
                } else if (empty($request->request->get("Email"))) {
                    return $this->json([
                        'message' => 'Veuiller remplir Email !',
                        'status' => 'error'
                    ]);
                } else if (empty($request->request->get("Telephone"))) {
                    return $this->json([
                        'message' => 'Veuiller remplir Telephone !',
                        'status' => 'error'
                    ]);
                } else if (empty($request->request->get("Address"))) {
                    return $this->json([
                        'message' => 'Veuiller remplir Address !',
                        'status' => 'error'
                    ]);
                }
                // return $this->json([
                //     'message' => 'Veuiller remplir tous les champ svp !',
                //     'status' => 'error'
                // ]);
            } else {

                $str = $request->request->get("Email");
                $pattern = "/@/i";
                $date = date('Y-m-d');

                if (preg_match($pattern, $str) === 1) {

                    if (empty($valpersonalInformation)) {
                        return $this->json([
                            'message' => 'Id Information non definie !',
                            'status' => 'error'
                        ]);
                    } else {

                        $info = $entityManager->getRepository(PersonalInformation::class)->findOneBy(["id" => $valpersonalInformation]);

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



                        // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                        $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                        $entityManager->flush();

                        return $this->json([
                            'message' => 'Modification effectué avec succès',
                            'status' => 'success'
                        ]);
                    }
                } else {
                    return $this->json([
                        'message' => 'Mail non valide',
                        'id' => $val->getId(),
                        'status' => 'error'
                    ]);
                }
                // }
            }
        }
    }
}