<?php

namespace App\Controller\Experience;

use App\Entity\ProfessionalExperience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceByIdController extends AbstractController
{
    /**
     * @Route("/experience/experience/by/id", name="app_experience_experience_by_id")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        if (empty($parametersAsArray["id"])) {
            return $this->json([
                'message' => 'Id Experience vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(ProfessionalExperience::class)->findBy(['id' => $parametersAsArray["id"]]);

            if ($val === null) {
                return $this->json([
                    'message' => 'Id undefined',
                    'status' => 'success'
                ]);
            } else {
                $array = [];

                foreach ($val as $infos) {
                    $val["job"] = $infos->getJob();
                    $val["company"] = $infos->getCompany();
                    $val["city"] = $infos->getCity();
                    $val["month_start"] = $infos->getMonthStart();
                    $val["year_start"] = $infos->getYearStart();
                    $val["month_end"] = $infos->getMonthEnd();
                    $val["year_end"] = $infos->getYearEnd();
                    $val["this_day"] = $infos->isThisDay();
                    $val["description"] = $infos->getDescription();


                    $array[] = $val;
                }

                return $this->json([
                    'message' => 'La liste des Experience',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}
