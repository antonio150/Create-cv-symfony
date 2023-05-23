<?php

namespace App\Controller\Formation;

use App\Entity\Curriculum;
use App\Entity\Formation;
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

                $formation = new Formation();

                $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $parametersAsArray["id_cv"]]);

                $array = [];

                foreach ($val as $infos) {
                    $formation->setIdCv($infos);


                    $array[] = $formation;
                }
                $formation->setTraining($parametersAsArray['training']);
                $formation->setEstablishment($parametersAsArray['establishment']);
                $formation->setCity($parametersAsArray['city']);
                $formation->setMonthStart($parametersAsArray['month_start']);
                $formation->setYearStart($parametersAsArray['year_start']);
                $formation->setMonthEnd($parametersAsArray['month_end']);
                $formation->setYearEnd($parametersAsArray['year_end']);
                $formation->setThisDay($parametersAsArray['this_day']);
                $formation->setDeleted(false);





                $formation->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                // $formation->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


                $form = $parametersAsArray;
                $vals = $formation->getId();

                $entityManager->persist($formation);
                $entityManager->flush();

                return $this->json([
                    'message' => 'Formation Créer',
                    'status' => 'success'
                ]);
            }
        }
    }
}