<?php

namespace App\Controller\CustomFieldInformation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomFieldInformationDeleteController extends AbstractController
{
    /**
     * @Route("/custom/field/information/custom/field/information/delete", name="app_custom_field_information_custom_field_information_delete")
     */
    public function index(): Response
    {
        return $this->render('custom_field_information/custom_field_information_delete/index.html.twig', [
            'controller_name' => 'CustomFieldInformationDeleteController',
        ]);
    }
}
