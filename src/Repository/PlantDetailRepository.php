<?php

namespace App\Repository;

use App\Entity\Users;
use App\Entity\PlantDetail;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<PlantDetail>
 */
class PlantDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlantDetail::class);
    }

    public function findOneById(string $id): ?PlantDetail
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findEnabledUserPlantsQuery(array $filters, Users $user)
    {
        $qb = $this->createQueryBuilder('pld')
            ->join('pld.userPlants', 'up')
            ->join('pld.Plant', 'p')
            ->andWhere('up.User = :User')
            ->setParameter('User', $user);
    
        if (!empty($filters['name'])) {
            $qb->andWhere('p.Name LIKE :name')
                ->setParameter('name', '%' . $filters['name'] . '%');
        }
    
        if (!empty($filters['species'])) {
            $qb->join('p.species', 's') // Joindre l'entité Species
                ->andWhere('s.id = :species')
                ->setParameter('species', (int)$filters['species']);
        }
    
        if (!empty($filters['families'])) {
            $qb->join('p.family', 'f') // Joindre l'entité Families
                ->andWhere('f.id = :family')
                ->setParameter('family', (int)$filters['families']);
        }
    
        if (!empty($filters['colors'])) {
            $qb->join('p.colors', 'c') // Joindre l'entité Colors
                ->andWhere('c.id = :color')
                ->setParameter('color', (int)$filters['colors']);
        }
    
        if (!empty($filters['seasons'])) {
            $qb ->join('p.seasons', 'se')
                ->andWhere('se.id = :seasonId')
                ->setParameter('seasonId', (int)$filters['seasons']);
        }
    
        if (!empty($filters['categories'])) {
            $qb->join('p.categories', 'ca') // Joindre l'entité Categories
                ->andWhere('ca.id = :category')
                ->setParameter('category', (int)$filters['categories']);
        }
    // dd($qb->getQuery()->getSQL(), $filters);
    
        return $qb->getQuery();
    }
    //    /**
    //     * @return PlantDetail[] Returns an array of PlantDetail objects
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

    //    public function findOneBySomeField($value): ?PlantDetail
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
