<?php

namespace App\Controller\Profil;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilUpdateController extends AbstractController
{
    /**
     * @Route("/profil/profil/update", name="app_profil_profil_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
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


            $info = $entityManager->getRepository(Profil::class)->find($parametersAsArray["id"]);

            $info->setDescription($parametersAsArray['description']);
            $info->setCurriculum($parametersAsArray['curriculum']);


            $entityManager->flush();

            return $this->json([
                'message' => 'Champ modifier',
                'status' => 'succes'
            ]);
        }
    }
}
