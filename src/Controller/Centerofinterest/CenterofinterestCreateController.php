<?php

namespace App\Controller\Centerofinterest;

use App\Entity\CenterOfInterest;
use App\Entity\Curriculum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterofinterestCreateController extends AbstractController
{
    /**
     * @Route("/centerofinterest/centerofinterest/create", name="app_centerofinterest_centerofinterest_create")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
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

            foreach ($parametersAsArray as $centerofinterestJson) {


            $date = date('Y-m-d');

            $centerofinterest = new CenterOfInterest();
                $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $centerofinterestJson["id_cv"]]);

            $array = [];

            foreach ($val as $infos) {
                $centerofinterest->setIdCv($infos);


            }

                $centerofinterest->setDescription($centerofinterestJson['description']);

            $centerofinterest->setIsDeleted(false);




            $centerofinterest->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
            // $centerofinterest->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $centerofinterestJson['updatedAt']));


            
            $entityManager->persist($centerofinterest);
            $entityManager->flush();
            }
            return $this->json([
                'message' => 'Centre d\'interet Créer avec succés',
                'status' => 'success'
            ]);
        }
    }
}