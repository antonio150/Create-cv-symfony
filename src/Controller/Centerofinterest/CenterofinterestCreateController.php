<?php

namespace App\Controller\Centerofinterest;

use App\Entity\CenterOfInterest;
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

        if (empty($parametersAsArray)) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {


            $date = date('Y-m-d');

            $centerofinterest = new CenterOfInterest();

            $centerofinterest->setDescription($parametersAsArray['description']);

            $centerofinterest->setIsDeleted(false);




            $centerofinterest->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
            // $centerofinterest->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


            $form = $parametersAsArray;
            $vals = $centerofinterest->getId();

            $entityManager->persist($centerofinterest);
            $entityManager->flush();

            return $this->json([
                'message' => 'Centre d\'interet Créer',
                'data' => $vals,
                'status' => 'success'
            ]);
        }
    }
}
