<?php

namespace App\Controller\Cv;

use App\Entity\Curriculum;
use App\Entity\PersonalInformation;
use App\Repository\CurriculumRepository;
use App\Repository\CustomFieldInformationRepository;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CvCreatewithInfomationController extends AbstractController
{
    /**
     * @Route("/cv/cv/createwith/infomation", name="app_cv_cv_createwith_infomation")
     */
    public function index(

        Request $request,
        SluggerInterface $slugger,

        EntityManagerInterface $entityManager,
        PersonalInformationRepository $personalInformationRepository
    ): Response {
        $date = date('Y-m-d');
        $cv = new Curriculum();

        $cv->setDeleted(false);
        $cv->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
        // $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));

        $entityManager->persist($cv);
        $entityManager->flush();
        // ======================================== Information =========================================

        $brochures_directory = $this->getParameter('brochures_directory');
        $infoVal = $personalInformationRepository->createInformation(
            $request,
            $entityManager,
            $slugger,
            $brochures_directory,
            $cv
        );

        // ======================================== UPDATE CV =========================================
        // ======================================== UPDATE CV =========================================

        // echo ($_GET["name"]);
        $valcv = $entityManager->getRepository(Curriculum::class)->findOneBy(['id' => $cv->getId()]);
        $valinfo = $entityManager->getRepository(PersonalInformation::class)->findOneBy(['id' => $infoVal]);
        // dd($profil->getId());
        $array = [];



        $valcv->setPersonalInformation($valinfo);

        // $entityManager->persist($valcv);
        $entityManager->flush();

        $output =  $cv->getId();

        return $this->json([
            "output" => $output
        ]);
    }
}