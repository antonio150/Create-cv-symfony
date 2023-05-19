<?php

namespace App\Controller\Experience;

use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceReadController extends AbstractController
{
    /**
     * @Route("/experience/experience/read", name="app_experience_experience_read")
     */
    public function index(
        Request $request,
        PersonalInformationRepository $info,
        EntityManagerInterface $entityManager
    ): JsonResponse {




        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(PersonalInformation::class);
        $data = $repository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["job"] = $item->getJob();
            $temp["company"] = $item->getCompany();
            $temp["city"] = $item->getCity();
            $temp["month_start"] = $item->getMonthStart();
            $temp["year_start"] = $item->getYearStart();
            $temp["month_end"] = $item->getMonthEnd();
            $temp["year_end"] = $item->getYearEnd();
            $temp["this_day"] = $item->isThisDay();
            $temp["description"] = $item->getDescription();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des utilisateurs',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}