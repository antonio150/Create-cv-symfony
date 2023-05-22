<?php

namespace App\Controller\Skill;

use App\Entity\Curriculum;
use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillUpdateController extends AbstractController
{
    /**
     * @Route("/skill/skill/update", name="app_skill_skill_update")
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
                empty($parametersAsArray['skill']) || empty($parametersAsArray['level'])
            ) {
                return $this->json([
                    'message' => 'Veuiller remplir tous les champ svp !',
                    'status' => 'error'
                ]);
            } else {


                $date = date('Y-m-d');


                if (empty($parametersAsArray["id"])) {
                    return $this->json([
                        'message' => 'Id Undefined !',
                        'status' => 'error'
                    ]);
                } else {

                    $skill = $entityManager->getRepository(Skill::class)->find($parametersAsArray["id"]);

                    $val = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $parametersAsArray["id_cv"]]);


                    $skill->setIdCv($val);

                    $skill->setSkill($parametersAsArray['skill']);
                    $skill->setLevel($parametersAsArray['level']);

                    $skill->setIsDeleted(false);


                    // $skill->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['createdAt']));
                    $skill->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $date));

                    $entityManager->flush();

                    return $this->json([
                        'message' => 'Champ modifier',
                        'status' => 'succes'
                    ]);
                }
            }
        }
    }
}