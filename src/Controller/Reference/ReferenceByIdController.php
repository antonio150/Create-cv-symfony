<?php

namespace App\Controller\Reference;

use App\Entity\Reference;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferenceByIdController extends AbstractController
{
    /**
     * @Route("/reference/reference/by/id", name="app_reference_reference_by_id")
     */
    public function index(
        Request $request,
        PersonalInformationRepository $info,
        EntityManagerInterface $entityManager
    ): Response {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        if (empty($parametersAsArray["id"])) {
            return $this->json([
                'message' => 'Id Reference vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(Reference::class)->findBy(['id' => $parametersAsArray["id"]], ['deleted' => false]);

            if ($val === null) {
                return $this->json([
                    'message' => 'Id undefined',
                    'status' => 'success'
                ]);
            } else {
                $array = [];

                foreach ($val as $infos) {
                    $val["id_cv"] = $infos->getIdCv();
                    $val["name"] = $infos->getName();
                    $val["company"] = $infos->getCompany();
                    $val["city"] = $infos->getCity();
                    $val["phone"] = $infos->getPhone();
                    $val["mail"] = $infos->getMail();




                    $array[] = $val;
                }




                return $this->json([
                    'message' => 'Liste des Reference',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}