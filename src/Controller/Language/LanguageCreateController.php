<?php

namespace App\Controller\Language;

use App\Entity\Language as EntityLanguage;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Language;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LanguageCreateController extends AbstractController
{
    /**
     * @Route("/language/language/create", name="app_language_language_create")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
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
                empty($parametersAsArray['language']) || empty($parametersAsArray['level'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {



                $date = date('Y-m-d');

                $lang = new EntityLanguage();

                $lang->setLanguage($parametersAsArray['language']);
               
                $lang->setIsDeleted(false);


                $lang->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                // $lang->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));


                $form = $parametersAsArray;
                $vals = $lang->getId();

                $entityManager->persist($lang);
                $entityManager->flush();

                return $this->json([
                        'message' => 'Modification effectué avec succès',
                    'data' => $vals,
                    'status' => 'success'
                ]);
            }
        }
    }
}