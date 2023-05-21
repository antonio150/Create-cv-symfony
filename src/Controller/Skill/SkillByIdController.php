<?php

namespace App\Controller\Skill;

use App\Entity\Skill;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillByIdController extends AbstractController
{
    /**
     * @Route("/skill/skill/by/id", name="app_skill_skill_by_id")
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
                'message' => 'Id Skill vide',
                'status' => 'error'
            ]);
        } else {

            $val = $entityManager->getRepository(Skill::class)->findBy(['id' => $parametersAsArray["id"]]);

            if ($val === null) {
                return $this->json([
                    'message' => 'Id undefined',
                    'status' => 'success'
                ]);
            } else {
                $array = [];

                foreach ($val as $infos) {
                    $val["skill"] = $infos->getSkill();
                    $val["level"] = $infos->getLevel();
                    $val["createdAt"] = $infos->getCreatedAt();
                    $val["updatedAt"] = $infos->getUpdatedAt();


                    $array[] = $val;
                }




                return $this->json([
                    'message' => 'liste of Skill',
                    'data' => $array,
                    'status' => 'success'
                ]);
            }
        }
    }
}