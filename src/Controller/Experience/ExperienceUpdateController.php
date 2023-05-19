<?php

namespace App\Controller\Experience;

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

        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {
            if (
                empty($parametersAsArray['name']) || empty($parametersAsArray['first_name']) || empty($parametersAsArray['email']) || empty($parametersAsArray['profil_title']) ||
                empty($parametersAsArray['telephone']) || empty($parametersAsArray['address'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {

                $str = $parametersAsArray['email'];
                $pattern = "/@/i";
                $date = date('Y-m-d');

                if (preg_match($pattern, $str) === 1) {

                    if (empty($parametersAsArray["id"])) {
                        return $this->json([
                            'message' => 'Id Undefined !',
                            'status' => 'error'
                        ]);
                    } else {

                        $formation = $entityManager->getRepository(PersonalInformation::class)->find($parametersAsArray["id"]);

                        $formation->setJob($parametersAsArray['job']);
                        $formation->setCompany($parametersAsArray['company']);
                        $formation->setCity($parametersAsArray['city']);
                        $formation->setMonthStart($parametersAsArray['month_start']);
                        $formation->setYearStart($parametersAsArray['year_start']);
                        $formation->setMonthEnd($parametersAsArray['month_end']);
                        $formation->setYearEnd($parametersAsArray['year_end']);
                        $formation->setThisDay($parametersAsArray['this_day']);
                        $formation->setIsDeleted(false);


                        // $formation->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                        $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));


                        $entityManager->flush();

                        return $this->json([
                            'message' => 'Champ modifier',
                            'status' => 'succes'
                        ]);
                    }
                } else {
                    return $this->json([
                        'message' => 'Mail non valide',
                        'status' => 'error'
                    ]);
                }
            }
        }
    }
}