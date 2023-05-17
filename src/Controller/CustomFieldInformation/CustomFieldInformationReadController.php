<?php

namespace App\Controller\CustomFieldInformation;

use App\Entity\CustomFieldInformation;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomFieldInformationReadController extends AbstractController
{
    /**
     * @Route("/custom/field/information/custom/field/information/read", name="app_custom_field_information_custom_field_information_read")
     */
    public function index(
        Request $request,
        PersonalInformationRepository $info,
        EntityManagerInterface $entityManager
    ): Response {

        $val = $entityManager->getRepository(CustomFieldInformation::class)->findAll();

        $array = [];

        foreach ($val as $infos) {
            $val["field_name"] = $infos->getFieldName();
            $val["field_contents"] = $infos->getFieldContents();
            $val["createdAt"] = $infos->getCreatedAt();
            $val["updatedAt"] = $infos->getUpdatedAt();
            $val["is_deleted"] = $infos->isIsDeleted();
            $val["personalInformation"] = $infos->getPersonalInformation();


            $array[] = $val;
        }




        return $this->json([
            'message' => 'Custom Field List',
            'data' => $array,
            'status' => 'success'
        ]);
    }
}
