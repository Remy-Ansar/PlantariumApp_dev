<?php

namespace App\Factory;

use App\Entity\Users;
use App\Entity\Plants;
use App\Entity\UserPlants;
use Symfony\Bundle\SecurityBundle\Security;

class UserPlantFactory
{
    public function __construct(
        private readonly Security $security,
    ) {   
    }

    public function createUserPlant(Users $user, Plants $plant): UserPlants
    {
        $userPlant = new UserPlants();
        $userPlant->setUser($user);
        $userPlant->setPlant($plant);

        return $userPlant;
    }
    // /**
    //  * Create a UserPlant object
    //  *
    //  * @param Users $user
    //  * @param Plants $plant
    //  * @return UserPlants
    //  */
    // public function createUserPlant(Plants $plant): UserPlants
    // {
    //     $userPlant = new UserPlants();

    //     if ($this->security->getUser()) {
    //         $userPlant->setUser($this->security->getUser());
    //     }
        
    //     $userPlant->setPlant($plant);

    //     return $userPlant;
    // }
}