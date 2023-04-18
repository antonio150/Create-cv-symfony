<?php

namespace App\Repository;

use App\Entity\CustomFieldInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomFieldInformation>
 *
 * @method CustomFieldInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomFieldInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomFieldInformation[]    findAll()
 * @method CustomFieldInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomFieldInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomFieldInformation::class);
    }

    public function add(CustomFieldInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomFieldInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CustomFieldInformation[] Returns an array of CustomFieldInformation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CustomFieldInformation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
