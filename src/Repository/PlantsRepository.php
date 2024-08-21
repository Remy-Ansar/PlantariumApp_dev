<?php

namespace App\Repository;

use App\Entity\Plants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;


/**
 * @extends ServiceEntityRepository<Plants>
 */
class PlantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plants::class);
    }

    public function findOneByName(string $name): ?Plants
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findOneById(string $id): ?Plants
    {
        return $this->findOneBy(['id' => $id]);
    }
    
    public function paginationOrder()
    {
    return $this->createQueryBuilder('p')
        ->orderBy('p.id', 'ASC');
    }

    
    public function findPlantsByName(string $name)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('p.Name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findPlantsBySpecies(int $speciesId)
    {
        return $this->createQueryBuilder('p')
            ->join('p.species', 's')
            ->andWhere('s.id = :speciesId')
            ->setParameter('speciesId', $speciesId)
            ->getQuery()
            ->getResult();
    }

    public function findPlantsByFamilies(int $familyId)
    {
        return $this->createQueryBuilder('p')
            ->join('p.families', 'f')
            ->andWhere('f.id = :familyId')
            ->setParameter('familyId', $familyId)
            ->getQuery()
            ->getResult();
    }

    public function findPlantsByColors(int $colorId)
{
    return $this->createQueryBuilder('p')
        ->join('p.colors', 'c') // Utilisez un alias 'c' pour clarity
        ->andWhere('c.id = :colorId') // Utilisez 'colorId' comme paramètre ici
        ->setParameter('colorId', $colorId)
        ->getQuery()
        ->getResult();
}

public function findPlantsBySeasons(int $seasonId)
{
    return $this->createQueryBuilder('p')
        ->join('p.seasons', 's') 
        ->andWhere('s.id = :seasonId') 
        ->setParameter('seasonId', $seasonId)
        ->getQuery()
        ->getResult();
}

public function findPlantsByCategories(int $categoryId)
{
    return $this->createQueryBuilder('p')
        ->join('p.categories', 'c') 
        ->andWhere('c.id = :categoryId') 
        ->setParameter('categoryId', $categoryId)
        ->getQuery()
        ->getResult();
}
}
    //    /**
    //     * @return Plants[] Returns an array of Plants objects
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

    //    public function findOneBySomeField($value): ?Plants
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
