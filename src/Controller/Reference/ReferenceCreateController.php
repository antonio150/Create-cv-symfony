<?php

namespace App\Controller\Reference;

use App\Entity\Curriculum;
use App\Entity\Reference;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferenceCreateController extends AbstractController
{
    /**
     * @Route("/reference/reference/create", name="app_reference_reference_create")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
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
            if (
                empty($parametersAsArray['name']) || empty($parametersAsArray['company']) || empty($parametersAsArray['city']) ||
                empty($parametersAsArray['phone']) || empty($parametersAsArray['mail'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {
                $str = $parametersAsArray['mail'];
                $pattern = "/@/i";

                $date = date('Y-m-d');
                if (preg_match($pattern, $str) === 1) {
                    $reference = new Reference();

                    $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $parametersAsArray["id_cv"]]);



                    foreach ($val as $references) {
                        $reference->setIdCv($references);
                    }

                    $reference->setName($parametersAsArray['name']);
                    $reference->setCompany($parametersAsArray['company']);
                    $reference->setCity($parametersAsArray['city']);
                    $reference->setPhone($parametersAsArray['phone']);
                    $reference->setMail($parametersAsArray['mail']);

                    $reference->setDeleted(false);


                    $reference->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $reference->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));



                    $entityManager->persist($reference);
                    $entityManager->flush();

                    return $this->json([
                        'message' => 'La liste des Information Créer',
                        'status' => 'success'
                    ]);
                } else {
                    return $this->json([
                        'message' => 'Email non valide',
                        'status' => 'error'
                    ]);
                }
            }
        }
    }
}