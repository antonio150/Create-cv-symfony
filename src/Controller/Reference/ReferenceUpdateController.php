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

class ReferenceUpdateController extends AbstractController
{
    /**
     * @Route("/reference/reference/update", name="app_reference_reference_update")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
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

                        if (empty($referenceJson["id"])) {
                        return $this->json(['message' => 'Id non definie !',
                            'status' => 'error'
                        ]);
                    } else {

                            $info = $entityManager->getRepository(Reference::class)->find($referenceJson["id"]);
                            $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $referenceJson["id_cv"]]);

                        $array = [];


                        $info->setIdCv($val);

                            $info->setName($referenceJson['name']);
                            $info->setCompany($referenceJson['company']);
                            $info->setCity($referenceJson['city']);
                            $info->setPhone($referenceJson['phone']);
                            $info->setMail($referenceJson['mail']);

                        $info->setDeleted(false);


                        // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $referenceJson['createdAt']));
                        $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                        $entityManager->flush();

                       
                    }
                } else {
                    return $this->json([
                        'message' => 'Mail non valide',
                        'status' => 'error'
                        ]);
                    }
                }
            }
            return $this->json([
                'message' => 'Modification effectué avec succès',
                'status' => 'success'
            ]);
        }
    }
}