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

    
    public function findPlantsWithFilters(array $filters)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $this->applyNameFilter($queryBuilder, $filters['name'] ?? null);
        $this->applyColorsFilter($queryBuilder, $filters['colors'] ?? null);
        $this->applyCategoriesFilter($queryBuilder, $filters['categories'] ?? null);
        $this->applyFamiliesFilter($queryBuilder, $filters['families'] ?? null);
        $this->applySpeciesFilter($queryBuilder, $filters['species'] ?? null);
        $this->applySeasonsFilter($queryBuilder, $filters['seasons'] ?? null);

        $queryBuilder->orderBy('p.Name', 'ASC');

        return $queryBuilder->getQuery();
    }

    private function applyNameFilter($queryBuilder, ?string $name)
    {
        if ($name) {
            $queryBuilder->andWhere('p.Name LIKE :name')
                         ->setParameter('name', '%' . $name . '%');
        }
    }

    private function applyColorsFilter($queryBuilder, ?array $colors)
    {
        if ($colors) {
            $queryBuilder->join('p.colors', 'c')
                         ->andWhere('c.id IN (:colors)')
                         ->setParameter('colors', $colors);
        }
    }

    private function applyCategoriesFilter($queryBuilder, ?array $categories)
    {
        if ($categories) {
            $queryBuilder->join('p.categories', 'ca')
                         ->andWhere('ca.id IN (:categories)')
                         ->setParameter('categories', $categories);
        }
    }

    private function applyFamiliesFilter($queryBuilder, ?int $family)
    {
        if ($family) {
            $queryBuilder->join('p.families', 'f')
                         ->andWhere('f.id = :family')
                         ->setParameter('family', $family);
        }
    }

    private function applySpeciesFilter($queryBuilder, ?int $species)
    {
        if ($species) {
            $queryBuilder->join('p.species', 's')
                         ->andWhere('s.id = :species')
                         ->setParameter('species', $species);
        }
    }

    private function applySeasonsFilter($queryBuilder, ?array $seasons)
    {
        if ($seasons) {
            $queryBuilder->join('p.seasons', 'se')
                         ->andWhere('se.id IN (:seasons)')
                         ->setParameter('seasons', $seasons);
        }
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
