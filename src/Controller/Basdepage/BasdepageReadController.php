<?php

namespace App\Controller\Basdepage;

use App\Entity\BasDePage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasdepageReadController extends AbstractController
{
    /**
     * @Route("/basdepage/basdepage/read", name="app_basdepage_basdepage_read")
     */
    public function readBasdepage(): Response
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(BasDePage::class);
        $data = $repository->findBy(['deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["description"] = $item->getDescription();


            $temp["createdAt"] = $item->getCreatedAt();
            $temp["updatedAt"] = $item->getUpdatedAt();
            array_push($output, $temp);
        }

        return $this->json(['message' => 'Liste des Bas de page',
            'BasDePage' => $output
        ]);
    }
}