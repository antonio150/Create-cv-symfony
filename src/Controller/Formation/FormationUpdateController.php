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

        $countNB = count($parametersAsArray);


        if ($countNB === 0) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            foreach ($parametersAsArray as $formationJson) {


                $date = date('Y-m-d');



                if (empty($formationJson["id"])) {
                    return $this->json(['message' => 'Id non definie !',
                        'status' => 'error'
                    ]);
                } else {
                    $formation = $entityManager->getRepository(Formation::class)->find($formationJson["id"]);
                    $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $formationJson["id_cv"]]);

                    $formation->setIdCv($val);

                    $formation->setTraining($formationJson['training']);
                    $formation->setEstablishment($formationJson['establishment']);
                    $formation->setCity($formationJson['city']);
                    $formation->setMonthStart($formationJson['month_start']);
                    $formation->setYearStart($formationJson['year_start']);
                    $formation->setMonthEnd($formationJson['month_end']);
                    $formation->setYearEnd($formationJson['year_end']);
                    $formation->setThisDay($formationJson['this_day']);



                    // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $formationJson['createdAt']));
                    $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

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