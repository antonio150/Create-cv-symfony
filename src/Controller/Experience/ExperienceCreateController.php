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

        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {
            if (
                empty($parametersAsArray['job']) || empty($parametersAsArray['company']) || empty($parametersAsArray['city']) ||
                empty($parametersAsArray['month_start']) || empty($parametersAsArray['year_start']) || empty($parametersAsArray['month_end']) || empty($parametersAsArray['year_end'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {

                $date = date('Y-m-d');

                $experience = new ProfessionalExperience();

                $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $parametersAsArray["id_cv"]]);

                $array = [];

                foreach ($val as $infos) {
                    $experience->setIdCv($infos);


                    $array[] = $experience;
                }

                $experience->setJob($parametersAsArray['job']);
                $experience->setCompany($parametersAsArray['company']);
                $experience->setCity($parametersAsArray['city']);
                $experience->setMonthStart($parametersAsArray['month_start']);
                $experience->setYearStart($parametersAsArray['year_start']);
                $experience->setMonthEnd($parametersAsArray['month_end']);
                $experience->setYearEnd($parametersAsArray['year_end']);
                $experience->setThisDay($parametersAsArray['this_day']);
                $experience->setIsDeleted(false);





                $experience->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                // $experience->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


                $entityManager->persist($experience);
                $entityManager->flush();

                return $this->json([
                    'message' => 'Experience Créer',
                    'status' => 'success'
                ]);
            }
        }
    }
}