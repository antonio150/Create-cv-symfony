<?php

namespace App\Controller\Skill;

use App\Entity\Skill;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillReadController extends AbstractController
{
    /**
     * @Route("/skill/skill/read", name="app_skill_skill_read")
     */
    public function index(): Response
    {
        $output = array();
        $temp = array();
        $repository = $this->getDoctrine()->getRepository(Skill::class);
        $data = $repository->findBy(['is_deleted' => false], array('id' => 'DESC'));

        foreach ($data as $item) {
            $temp["id_cv"] = $item->getIdCv();
            $temp["skill"] = $item->getSkill();
            $temp["level"] = $item->getLevel();


            $temp["createdAt"] = $item->getCreatedAt();
            $temp["updatedAt"] = $item->getUpdatedAt();
            array_push($output, $temp);
        }

        return $this->json([
            'message' => 'List of skill',
            'data' => $output,
            'status' => 'success'
        ]);
    }
}