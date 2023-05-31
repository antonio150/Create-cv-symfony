<?php

namespace App\Controller\Information;

use App\Entity\PersonalInformation;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class InformationCreateController extends AbstractController
{
    /**
     * @Route("/information/information/create", name="app_information_information_create")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        PersonalInformationRepository $personalInformationRepository
    ): JsonResponse {
     
            if (
            empty($request->request->get("Name")) || empty($request->request->get("FirstName")) || empty($request->request->get("Email")) ||
            empty($request->request->get("Telephone")) || empty($request->request->get("Address")) 
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {
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

                $personalInformationRepository->add($info, true);
                 
                    // $entityManager->persist($info);
                    // $entityManager->flush();

                    return $this->json([
                        'message' => 'Liste des Informations créer avec succés',
                        
                        'status' => 'success'
                    ]);
                } else {
                    return $this->json([
                        'message' => 'Email non valide',
                        'status' => 'error'
                    ]);
                }
                    
                    

                   
            // }
        }
    }
}