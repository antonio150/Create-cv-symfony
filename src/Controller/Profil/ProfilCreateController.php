<?php

namespace App\Controller\Profil;

use App\Entity\Profil;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilCreateController extends AbstractController
{
    /**
     * @Route("/profil/profil/create", name="app_profil_profil_create")
     */
    public function index(
        EntityManager $entityManager,
        Request $request
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

            $info = new Profil();

            $info->setDescription($parametersAsArray['description']);
            $info->setCurriculum($parametersAsArray['curriculum']);


            $entityManager->persist($info);
            $entityManager->flush();

            return $this->json([
                'message' => 'Profil Créer',
                'status' => 'success'
            ]);
        }
    }
}
