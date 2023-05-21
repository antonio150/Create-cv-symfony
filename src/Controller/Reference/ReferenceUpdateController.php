<?php

namespace App\Controller\Reference;

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

                    if (empty($parametersAsArray["id"])) {
                        return $this->json([
                            'message' => 'Id Undefined !',
                            'status' => 'error'
                        ]);
                    } else {

                        $info = $entityManager->getRepository(Reference::class)->find($parametersAsArray["id"]);

                        $info->setName($parametersAsArray['name']);
                        $info->setCompany($parametersAsArray['company']);
                        $info->setCity($parametersAsArray['city']);
                        $info->setPhone($parametersAsArray['phone']);
                        $info->setMail($parametersAsArray['mail']);

                        $info->setDeleted(false);


                        // $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                        $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                        $entityManager->flush();

                        return $this->json([
                            'message' => 'Champ modifier',
                            'status' => 'succes'
                        ]);
                    }
                } else {
                    return $this->json([
                        'message' => 'Mail non valide',
                        'status' => 'error'
                    ]);
                }
            }
        }
    }
}
