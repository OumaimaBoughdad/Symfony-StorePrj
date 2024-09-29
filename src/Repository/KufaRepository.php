<?php

namespace App\Repository;

use App\Entity\Kufa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kufa>
 *
 * @method Kufa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kufa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kufa[]    findAll()
 * @method Kufa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KufaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kufa::class);
    }

//    /**
//     * @return Kufa[] Returns an array of Kufa objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('k.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Kufa
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
