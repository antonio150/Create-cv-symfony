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

            if (empty($parametersAsArray["id"])) {
                return $this->json([
                    'message' => 'Id Undefined !',
                    'status' => 'error'
                ]);
            } else {
                $date = date('Y-m-d');

                $profil = $entityManager->getRepository(Profil::class)->find($parametersAsArray["id"]);

                $profil->setDescription($parametersAsArray['description']);
                // $profil->setCurriculum($parametersAsArray['curriculum']);

                // $profil->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                $profil->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

            $entityManager->flush();

            return $this->json([
                'message' => 'Champ modifier',
                    'status' => 'success'
            ]);

        }
        }
    }
}