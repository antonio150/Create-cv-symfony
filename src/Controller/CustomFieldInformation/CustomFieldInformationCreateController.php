<?php

namespace App\Controller\CustomFieldInformation;

use App\Entity\CustomFieldInformation;
use App\Entity\PersonalInformation;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomFieldInformationCreateController extends AbstractController
{
    /**
     * @Route("/custom/field/information/custom/field/information/create", name="app_custom_field_information_custom_field_information_create")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $info = $entityManager->getRepository(PersonalInformation::class)->find('12');

        foreach ($info as $val) {
            $val = $info->getId();
        }


        $customInfo = new CustomFieldInformation();

        $field_name = isset($parametersAsArray['field_name']) ? $parametersAsArray['field_name'] : NULL;
        $field_contents = isset($parametersAsArray['field_contents']) ? $parametersAsArray['field_contents'] : NULL;
        // $createdAt = isset($parametersAsArray['createdAt']) ? $parametersAsArray['createdAt'] : NULL;
        $updatedAt = isset($parametersAsArray['updatedAt']) ? $parametersAsArray['updatedAt'] : NULL;
        $is_deleted = isset($parametersAsArray['is_deleted']) ? $parametersAsArray['is_deleted'] : NULL;

        $customInfo->setFieldName($field_name);
        $customInfo->setFieldContents($field_contents);
        $customInfo->setCreatedAt(new DateTime());
        $customInfo->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $updatedAt));
        $customInfo->setIsDeleted(\DateTime::createFromFormat('Y-m-d', $is_deleted));
        // $customInfo->setPersonalInformation($info);

        $entityManager->persist($customInfo);
        $entityManager->flush();


        return $this->json([
            'message' => 'Custom Field Created',
            'data' => $info->getId(),
            'status' => 'success'
        ]);
    }
}
