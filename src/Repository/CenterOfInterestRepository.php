<?php

namespace App\Repository;

use App\Entity\CenterOfInterest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CenterOfInterest>
 *
 * @method CenterOfInterest|null find($id, $lockMode = null, $lockVersion = null)
 * @method CenterOfInterest|null findOneBy(array $criteria, array $orderBy = null)
 * @method CenterOfInterest[]    findAll()
 * @method CenterOfInterest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CenterOfInterestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CenterOfInterest::class);
    }

    public function add(CenterOfInterest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CenterOfInterest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CenterOfInterest[] Returns an array of CenterOfInterest objects
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

//    public function findOneBySomeField($value): ?CenterOfInterest
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
