<?php

namespace App\Repository;

use App\Entity\GitLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GitLink>
 *
 * @method GitLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method GitLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method GitLink[]    findAll()
 * @method GitLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GitLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GitLink::class);
    }

//    /**
//     * @return GitLink[] Returns an array of GitLink objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GitLink
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
