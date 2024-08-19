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
