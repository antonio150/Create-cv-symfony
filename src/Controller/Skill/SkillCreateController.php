<?php

namespace App\Controller\Skill;

use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillCreateController extends AbstractController
{
    /**
     * @Route("/skill/skill/create", name="app_skill_skill_create")
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
                empty($parametersAsArray['skill']) || empty($parametersAsArray['level'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {

                $info = new Skill();
                $date = date('Y-m-d');

                $info->setSkill($parametersAsArray['skill']);
                $info->setLevel($parametersAsArray['level']);
                $info->setIsDeleted(false);

                $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                // $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));

                $entityManager->persist($info);
                $entityManager->flush();

                return $this->json([
                    'message' => 'Skill Créer',
                    'status' => 'success'
                ]);
            }
        }
    }
}