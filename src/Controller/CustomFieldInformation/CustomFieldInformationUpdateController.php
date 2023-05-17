<?php

namespace App\Controller\CustomFieldInformation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomFieldInformationUpdateController extends AbstractController
{
    /**
     * @Route("/custom/field/information/custom/field/information/update", name="app_custom_field_information_custom_field_information_update")
     */
    public function index(): Response
    {
        return $this->render('custom_field_information/custom_field_information_update/index.html.twig', [
            'controller_name' => 'CustomFieldInformationUpdateController',
        ]);
    }
}
