<?php

namespace App\Controller\Experience;

use App\Entity\Curriculum;
use App\Entity\ProfessionalExperience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceCreateController extends AbstractController
{
    /**
     * @Route("/experience/experience/create", name="app_experience_experience_create")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
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



                $experience = new ProfessionalExperience();

                $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $experienceJson["id_cv"]]);

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
            return $this->json([
                'message' => 'Experience créer avec succés',
                'status' => 'success'
            ]);
        }
    }
}