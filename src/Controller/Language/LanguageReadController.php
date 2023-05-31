<?php

namespace App\Controller\Language;

use App\Entity\Language;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageReadController extends AbstractController
{
    /**
     * @Route("/language/language/read", name="app_language_language_read")
     */
    public function readLanguage(): Response
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(Language::class);
        $data = $repository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["language"] = $item->getLanguage();
          

            $temp["createdAt"] = $item->getCreatedAt();
            $temp["updatedAt"] = $item->getUpdatedAt();
            array_push($output, $temp);
        }

        return $this->json([
            'Language' => $output
           
        ]);
    }
}