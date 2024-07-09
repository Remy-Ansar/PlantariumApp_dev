<?php
namespace App\Storage;

use App\Entity\Plants;
use App\Repository\PlantsRepository;

class PlantsStorage
{
    public function __construct(
        private readonly PlantsRepository $plantsRepository,
    )
    {
        
    }

    // public function getPlant(): ?Plants
    // {
    //     return $this->plantsRepository->findOneBy([
    //         'id' => $this->getPlantId(),
    //     ]);
    // }

    // /**
    //  * Get the cart id from session
    //  *
    //  * @return integer|null
    //  */
    // private function getPlantId(Plants $plant): ?int
    // {
    //     return $this->$plant()->get('id');
    // }
}