<?php

namespace App\Controller\Formation;

use App\Entity\Curriculum;
use App\Entity\Formation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationUpdateController extends AbstractController
{
    /**
     * @Route("/formation/formation/update", name="app_formation_formation_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
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
                empty($parametersAsArray['training']) || empty($parametersAsArray['establishment']) || empty($parametersAsArray['city']) ||
                empty($parametersAsArray['month_start']) || empty($parametersAsArray['year_start']) || empty($parametersAsArray['month_end']) || empty($parametersAsArray['year_end'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {


                $date = date('Y-m-d');



                if (empty($parametersAsArray["id"])) {
                    return $this->json([
                        'message' => 'Id Undefined !',
                        'status' => 'error'
                    ]);
                } else {
                    $formation = $entityManager->getRepository(Formation::class)->find($parametersAsArray["id"]);
                    $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $parametersAsArray["id_cv"]]);

                    $array = [];


                    $formation->setIdCv($val);

                    $formation->setTraining($parametersAsArray['training']);
                    $formation->setEstablishment($parametersAsArray['establishment']);
                    $formation->setCity($parametersAsArray['city']);
                    $formation->setMonthStart($parametersAsArray['month_start']);
                    $formation->setYearStart($parametersAsArray['year_start']);
                    $formation->setMonthEnd($parametersAsArray['month_end']);
                    $formation->setYearEnd($parametersAsArray['year_end']);
                    $formation->setThisDay($parametersAsArray['this_day']);



                    // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                    $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    return $this->json([
                        'message' => 'Champ modifier',
                        'status' => 'success'
                    ]);
                }
            }
        }
    }
}