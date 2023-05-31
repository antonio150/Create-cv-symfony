<?php

namespace App\Controller\Skill;

use App\Entity\Curriculum;
use App\Entity\Skill;
use App\Repository\SkillRepository;
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
        EntityManagerInterface $entityManager,
        SkillRepository $skillRepository
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

                $skill = new Skill();
                $date = date('Y-m-d');

                $val = $entityManager->getRepository(Curriculum::class)->findBy(['id' => $parametersAsArray["id_cv"]]);



                foreach ($val as $references) {
                    $skill->setIdCv($references);
                }

                $skill->setSkill($parametersAsArray['skill']);
                $skill->setLevel($parametersAsArray['level']);
                $skill->setIsDeleted(false);

                $skill->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
                // $skill->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));

                // $entityManager->persist($skill);
                // $entityManager->flush();
                $skillRepository->add($skill, true);

                return $this->json([
                    'message' => 'Skill créer avec succés',
                    'status' => 'success'
                ]);
            }
        }
    }
}