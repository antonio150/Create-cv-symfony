<?php

namespace App\Controller\Centerofinterest;

use App\Entity\CenterOfInterest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterofinterestReadController extends AbstractController
{
    /**
     * @Route("/centerofinterest/centerofinterest/read", name="app_centerofinterest_centerofinterest_read")
     */
    public function readCenterofinterest(): Response
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(CenterOfInterest::class);
        $data = $repository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["id_cv"] = $item->getIdCv();
            $temp["description"] = $item->getDescription();


            $temp["createdAt"] = $item->getCreatedAt();
            $temp["updatedAt"] = $item->getUpdatedAt();
            array_push($output, $temp);
        }

        return $this->json(['message' => 'Liste des Centerofinterest',
            'CenterOfInterest' => $output
        ]);
    }
}