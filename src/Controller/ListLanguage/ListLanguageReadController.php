<?php

namespace App\Controller\ListLanguage;

use App\Entity\ListLanguage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListLanguageReadController extends AbstractController
{
    /**
     * @Route("/list/language/list/language/read", name="app_list_language_list_language_read")
     */
    public function readListlanguage(): Response
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(ListLanguage::class);
        $data = $repository->findBy(['deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["id_cv"] = $item->getIdCv();
            $temp["id_language"] = $item->getIdLanguage();
            $temp["note_language"] = $item->getNoteLanguage();

            $temp["createdAt"] = $item->getCreatedAt();
            $temp["updatedAt"] = $item->getUpdatedAt();
            array_push($output, $temp);
        }

        return $this->json([
            'ListLanguage' => $output
        ]);
    }
}