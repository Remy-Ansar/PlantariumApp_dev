<?php

namespace App\EventListener;

use App\Entity\Users;
use App\Entity\UserInfos;
use App\Entity\UserPlants;
use Doctrine\ORM\Event\PostPersistEventArgs;

class UserEntityListener
{
    public function postPersist(Users $user, PostPersistEventArgs $event): void
    {
        $entityManager = $event->getObject();

        $userPlant = new UserPlants();
        $userPlant->setUser($user);

        $entityManager->persist($userPlant);
        $entityManager->flush();
    }
}