<?php

namespace App\Repository;

use App\Entity\UserInfos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserInfos>
 */
class UserInfosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserInfos::class);
    }

    public function findOneByFirstName(string $firstname): ?UserInfos
    {
        return $this->findOneBy(['FirstName' => $firstname]);
    }

    public function findOneByLastName(string $lastname): ?UserInfos
    {
        return $this->findOneBy(['LastName' => $lastname]);
    }
    
    public function findByFullName(?string $firstName = null, ?string $lastName = null)
{
    $qb = $this->createQueryBuilder('ui')
        ->leftJoin('ui.users', 'u');

    // Vérification des champs et application des filtres
    if ($firstName) {
        $qb->andWhere('ui.FirstName LIKE :firstName')
           ->setParameter('firstName', '%' . $firstName . '%');
    }

    if ($lastName) {
        $qb->andWhere('ui.LastName LIKE :lastName')
           ->setParameter('lastName', '%' . $lastName . '%');
    }

    // Si aucune condition n'est remplie, ne retourner aucun résultat
    if (!$firstName && !$lastName) {
        return [];
    }

    return $qb->getQuery()->getResult();
}
}

    //    /**
    //     * @return UserInfos[] Returns an array of UserInfos objects
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

    //    public function findOneBySomeField($value): ?UserInfos
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

