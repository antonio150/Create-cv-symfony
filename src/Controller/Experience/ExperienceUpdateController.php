<?php

namespace App\Controller\Experience;

use App\Entity\Curriculum;
use App\Entity\ProfessionalExperience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceUpdateController extends AbstractController
{
    /**
     * @Route("/experience/experience/update", name="app_experience_experience_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): JsonResponse {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

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
    }
}