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

        $countNB = count($parametersAsArray);


        if ($countNB === 0) {
            return $this->json([
                'message' => 'Le champ est vide',
                'status' => 'error'
            ]);
        } else {

            foreach ($parametersAsArray as $referenceJson) {
            if (
                    empty($referenceJson['name']) || empty($referenceJson['company']) || empty($referenceJson['city']) ||
                    empty($referenceJson['phone']) || empty($referenceJson['mail'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {
                    $str = $referenceJson['mail'];
                $pattern = "/@/i";

                $date = date('Y-m-d');
                if (preg_match($pattern, $str) === 1) {
                    $reference = new Reference();

                        $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $referenceJson["id_cv"]]);



                    foreach ($val as $references) {
                        $reference->setIdCv($references);
                    }

                        $reference->setName($referenceJson['name']);
                        $reference->setCompany($referenceJson['company']);
                        $reference->setCity($referenceJson['city']);
                        $reference->setPhone($referenceJson['phone']);
                        $reference->setMail($referenceJson['mail']);

                    $reference->setDeleted(false);


                    $reference->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                    // $reference->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $referenceJson['updatedAt']));



                    $entityManager->persist($reference);
                    $entityManager->flush();

                    
                } else {
                    return $this->json([
                        'message' => 'Email non valide',
                        'status' => 'error'
                    ]);
                }
            }
            }
            return $this->json([
                'message' => 'Reference créer avec succés',
                'status' => 'success'
            ]);
        }
    }
}