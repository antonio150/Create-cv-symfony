<?php

namespace App\Controller\Basdepage;

use App\Entity\BasDePage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasdepageCreateController extends AbstractController
{
    /**
     * @Route("/basdepage/basdepage/create", name="app_basdepage_basdepage_create")
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

            $basdepage = new BasDePage();

            $basdepage->setDescription($parametersAsArray['description']);

            $basdepage->setDeleted(false);




            $basdepage->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
            // $basdepage->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


            $form = $parametersAsArray;
            $vals = $basdepage->getId();

            $entityManager->persist($basdepage);
            $entityManager->flush();

            return $this->json([
                'message' => 'Bas de page Créer',
                'data' => $vals,
                'status' => 'success'
            ]);
        }
    }
}
