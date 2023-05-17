<?php

namespace App\Controller\Profil;

use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilByIdController extends AbstractController
{
    /**
     * @Route("/profil/profil/by/id", name="app_profil_profil_by_id")
     */
    public function index(ProfilRepository $profilRepository): Response
    {
        $output = array();
        $temp = array();
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(), true);

        $dataQuery = $profilRepository->findBy(['id' => $data["id"]]);

        if (empty($dataQuery)) {
            $output = array(
                'message' => 'Profil introuvable ! ',
                'status' => 'erreur'
            );
        }

        foreach ($dataQuery as $item) {
            $temp["id"] = $item->getId();
            $temp["description"] = $item->getDescription();
            $temp["curriculum"] = $item->getCurriculum();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'Info Profil',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}
