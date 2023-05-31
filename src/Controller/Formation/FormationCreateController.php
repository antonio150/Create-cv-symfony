<?php

namespace App\Controller\Formation;

use App\Entity\Curriculum;
use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationCreateController extends AbstractController
{
    /**
     * @Route("/formation/formation/create", name="app_formation_formation_create")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request,
        FormationRepository $formationRepository
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

                $formation = new Formation();

                $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $formationJson["id_cv"]]);

                $array = [];

                foreach ($val as $infos) {
                    $formation->setIdCv($infos);


                    $array[] = $formation;
                }
                $formation->setTraining($formationJson['training']);
                $formation->setEstablishment($formationJson['establishment']);
                $formation->setCity($formationJson['city']);
                $formation->setMonthStart($formationJson['month_start']);
                $formation->setYearStart($formationJson['year_start']);
                $formation->setMonthEnd($formationJson['month_end']);
                $formation->setYearEnd($formationJson['year_end']);
                $formation->setThisDay($formationJson['this_day']);
                $formation->setDeleted(false);

                $formation->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                // $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $formationJson['updatedAt']));



                // $entityManager->persist($formation);
                // $entityManager->flush();
                $formationRepository->add($formation, true);

            }
            return $this->json([
                'message' => 'Formation créé avec succès',
                'status' => 'success'
            ]);
        }
    }
}