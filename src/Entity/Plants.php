<?php

namespace App\Entity;

use App\Repository\PlantsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlantsRepository::class)]
class Plants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Specie = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'plants')]
    private ?UserPlants $userPlants = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSpecie(): ?string
    {
        return $this->Specie;
    }

    public function setSpecie(?string $Specie): static
    {
        $this->Specie = $Specie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

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
}
