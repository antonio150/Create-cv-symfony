<?php

namespace App\Controller\Profil;

use App\Entity\Profil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilReadController extends AbstractController
{
    /**
     * @Route("/profil/profil/read", name="app_profil_profil_read")
     */
    public function index(): Response
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(Profil::class);
        $data = $repository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["id"] = $item->getId();
            $temp["description"] = $item->getDescription();
            $temp["curriculum"] = $item->getgetCurriculum();

            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'La liste des profil',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
