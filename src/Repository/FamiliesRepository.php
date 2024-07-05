<?php

namespace App\Repository;

use App\Entity\Families;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Families>
 */
class FamiliesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Families::class);
    }

    public function findOneByName(string $name): ?Families
    {
        return $this->findOneBy(['Name' => $name]);
    }

    
    /**
     * @param string $sort
     * @return Families[]
     */
    public function findAllOrderByName(string $sort = 'ASC'): array
    {
        $sort = strtoupper($sort);
        if (!in_array($sort, ['ASC', 'DESC'])) {
            throw new \InvalidArgumentException('Invalid sort direction');
        }

        return $this->createQueryBuilder('f')
            ->orderBy('f.Name', $sort)
            ->getQuery()
            ->getResult();
    }
}
    //    /**
    //     * @return Families[] Returns an array of Families objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Families
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

