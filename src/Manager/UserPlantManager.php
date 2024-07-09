<?php

namespace App\Manager;

use App\Entity\Plants;
use App\Entity\UserPlants;
use App\Factory\UserPlantFactory;
use App\Repository\PlantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class UserPlantManager
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPlantFactory $userPlantFactory,
        private readonly Security $security,
        private readonly PlantsRepository $plantsRepository
    ) {
    }

    public function save(UserPlants $userPlant): void
    {
        $this->em->persist($userPlant);
        $this->em->flush();
    }
}
    // /**
    //  * Get the current plant id
    //  *
    //  * @return ?Plants
    //  */
    // public function getCurrentPlant(): ?Plants
    // {
    //     $plant = $this->plantsRepository->findOneById('id');
    // }

    // /**
    //  * Set the current plant for UserPlant
    //  *
    //  * @param Plants $plant
    //  * @return void
    //  */
    // public function setCurrentPlant(Plants $plant): void
    // {   
    //     $this->getPlantId()-<$set()
    // }
