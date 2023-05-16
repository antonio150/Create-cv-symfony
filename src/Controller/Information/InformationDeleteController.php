<?php

namespace App\Controller\Information;

use App\Entity\PersonalInformation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationDeleteController extends AbstractController
{
    /**
     * @Route("/information/information/delete", name="app_information_information_delete")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager

    ): Response {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }


        $val = $entityManager->getRepository(PersonalInformation::class)->find($parametersAsArray["id"]);


        $entityManager->remove($val);
        $entityManager->flush();

        return $this->json([
            'message' => 'Champ supprimer',
            'status' => 'succes'
        ]);
    }
}
