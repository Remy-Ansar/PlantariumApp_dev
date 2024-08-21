<?php

namespace App\Repository;

use App\Entity\Users;
use App\Entity\UserPlants;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    

    /**
     * Récupère les plantes d'un utilisateur spécifique
     *
     * @param Users $user
     * @return UserPlants[]
     */
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
            ->join('p.colors', 'c')
            ->andWhere('c.id = :colorId')
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
    
    //    /**
    //     * @return UserPlants[] Returns an array of UserPlants objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserPlants
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
