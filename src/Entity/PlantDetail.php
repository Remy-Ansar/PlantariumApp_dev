<?php

namespace App\Entity;

use App\Repository\PlantDetailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlantDetailRepository::class)]
class PlantDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Journal = null;

    #[ORM\ManyToOne(inversedBy: 'plantDetails')]
    private ?UserPlants $userPlants = null;

    #[ORM\ManyToOne(inversedBy: 'plantDetails')]
    private ?Plants $Plant = null;

    #[ORM\ManyToOne(inversedBy: 'plantDetails')]
    private ?HealthStatus $HealthStatus = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJournal(): ?string
    {
        return $this->Journal;
    }

    public function setJournal(?string $Journal): static
    {
        $this->Journal = $Journal;

        return $this;
    }

    public function getUserPlants(): ?UserPlants
    {
        return $this->userPlants;
    }

    public function setUserPlants(?UserPlants $userPlants): static
    {
        $this->userPlants = $userPlants;

        return $this;
    }

    public function getPlant(): ?Plants
    {
        return $this->Plant;
    }

    public function setPlant(?Plants $Plant): static
    {
        $this->Plant = $Plant;

        return $this;
    }

    public function getHealthStatus(): ?HealthStatus
    {
        return $this->HealthStatus;
    }

    public function setHealthStatus(?HealthStatus $HealthStatus): static
    {
        $this->HealthStatus = $HealthStatus;

        return $this;
    }
}
