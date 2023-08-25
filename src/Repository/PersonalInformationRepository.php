<?php

namespace App\Repository;

use App\Entity\Curriculum;
use App\Entity\PersonalInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @extends ServiceEntityRepository<PersonalInformation>
 *
 * @method PersonalInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalInformation[]    findAll()
 * @method PersonalInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalInformation::class);
    }

    public function add(PersonalInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PersonalInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function createInformation(
        $request,
        $entityManager,
        $slugger,
        $brochures_directory,
        $cv

    ) {
        $str = $request->request->get("Email");
        $pattern = "/@/i";

        $date = date('Y-m-d');



        $info = new PersonalInformation();


        $info->setName($request->request->get("Name"));
        $info->setFirstName($request->request->get("FirstName"));
        $info->setEmail($request->request->get("Email"));
        $info->setTelephone($request->request->get("Telephone"));
        $info->setAddress($request->request->get("Address"));
        $info->setPostalCode($request->request->get("PostalCode"));
        $info->setCity($request->request->get("City"));
        $info->setSexe($request->request->get("Sexe"));
        $info->setNationality($request->request->get("Nationality"));
        $info->setMaritalStatus($request->request->get("MartialStatus"));
        $info->setIsDeleted(false);



        $brochureFile = $request->files->get('file');


        if ($brochureFile) {
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();


            try {
                $brochureFile->move(
                    $brochures_directory,
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $info->setPhoto($newFilename);

            $info->setPath($brochures_directory);
        }




        $info->setPosition($request->request->get("Position"));
        $info->setDatenaiss(\DateTime::createFromFormat('Y-m-d', $date));
        $info->setLieudenaiss("zzz");
        $info->setDriverLicense($request->request->get("DriverLicense"));



        $info->setCreatedAt(\DateTime::createFromFormat('Y-m-d', $date));
        // $info->setUpdatedAt(\DateTime::createFromFormat('Y-m-d', $parametersAsArray['updatedAt']));



        $entityManager->persist($info);
        $entityManager->flush();



        $output =  $cv->getId();

        return  $output;
    }

    //    /**
    //     * @return PersonalInformation[] Returns an array of PersonalInformation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PersonalInformation
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}