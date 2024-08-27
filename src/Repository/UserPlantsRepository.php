<?php

namespace App\Repository;

use App\Entity\Users;
use App\Entity\UserPlants;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Plants;

/**
 * @extends ServiceEntityRepository<UserPlants>
 */
class UserPlantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPlants::class);
    }

    public function findOneById(string $id): ?UserPlants
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findOneByName(string $name): ?Plants
    {
        return $this->findOneBy(['name' => $name]);
    }
    
    public function findUserPlantsByUser(Users $user): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.User = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    public function paginationOrder()
    {
    return $this->createQueryBuilder('p')
        ->orderBy('p.id', 'ASC');
    }
    
    public function findUserPlantsByName(string $name)
    {
        return $this->createQueryBuilder('up')
            ->andWhere('up.plant.Name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('p.Name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findUserPlantsBySpecies(int $speciesId)
    {
        return $this->createQueryBuilder('up')
            ->join('up.plant.species', 's')
            ->andWhere('s.id = :speciesId')
            ->setParameter('speciesId', $speciesId)
            ->getQuery()
            ->getResult();
    }

    public function findUserPlantsByFamilies(int $familyId)
    {
        return $this->createQueryBuilder('up')
            ->join('up.plant.families', 'f')
            ->andWhere('f.id = :familyId')
            ->setParameter('familyId', $familyId)
            ->getQuery()
            ->getResult();
    }

    public function findUserPlantsByColors(int $colorId)
    {
        return $this->createQueryBuilder('up')
            ->join('up.plant.colors', 'c') // Utilisez un alias 'c' pour clarity
            ->andWhere('c.id = :colorId') // Utilisez 'colorId' comme paramètre ici
            ->setParameter('colorId', $colorId)
            ->getQuery()
            ->getResult();
    }

    public function findUserPlantsBySeasons(int $seasonId)
    {
        return $this->createQueryBuilder('up')
            ->join('up.plant.seasons', 's') 
            ->andWhere('s.id = :seasonId') 
            ->setParameter('seasonId', $seasonId)
            ->getQuery()
            ->getResult();
    }

    public function findPlantsByCategories(int $categoryId)
{
    return $this->createQueryBuilder('up')
        ->join('up.plant.categories', 'c') 
        ->andWhere('c.id = :categoryId') 
        ->setParameter('categoryId', $categoryId)
        ->getQuery()
        ->getResult();
}
public function findEnabledPlantsQuery(array $filters)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.enable = :enabled')
            ->setParameter('enabled', 1);
    
        if (!empty($filters['name'])) {
            $qb->andWhere('p.name LIKE :name')
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
            $qb->join('p.seasons', 'se') // Joindre l'entité Seasons
                ->andWhere('se.id = :season')
                ->setParameter('season', (int)$filters['seasons']);
        }
    
        if (!empty($filters['categories'])) {
            $qb->join('p.categories', 'ca') // Joindre l'entité Categories
                ->andWhere('ca.id = :category')
                ->setParameter('category', (int)$filters['categories']);
        }
    
        return $qb->getQuery();
    }

}