<?php

namespace App\Controller\Profil;

use App\Entity\Curriculum;
use App\Entity\Profil;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

            $info = new Profil();
            $date = date('Y-m-d');
            $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $parametersAsArray["id_cv"]]);



            foreach ($val as $references) {
                $info->setIdCv($references);
            }


            // $info->setIdCv($parametersAsArray['id_cv']);
            $info->setDescription($parametersAsArray['description']);
            // $info->setCurriculum($parametersAsArray['curriculum']);
            $info->setIsDeleted(false);

            $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));

            $entityManager->persist($info);
            $entityManager->flush();

            return $this->json([
                'message' => 'Profil ajouter avec succès',
                'status' => 'success'
            ]);
        }
    }
}