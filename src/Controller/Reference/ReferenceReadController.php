<?php

namespace App\Controller\Reference;

use App\Entity\Reference;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferenceReadController extends AbstractController
{
    /**
     * @Route("/reference/reference/read", name="app_reference_reference_read")
     */
    public function index(): Response
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(Reference::class);
        $data = $repository->findBy(['deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["id_cv"] = $item->getIdCv();
            $temp["name"] = $item->getName();
            $temp["company"] = $item->getCompany();
            $temp["city"] = $item->getCity();
            $temp["phone"] = $item->getPhone();
            $temp["mail"] = $item->getMail();

            $temp["createdAt"] = $item->getCreatedAt();
            $temp["updatedAt"] = $item->getUpdatedAt();
            array_push($output, $temp);
        }

        return $this->json(['message' => 'Liste des utilisateurs',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}