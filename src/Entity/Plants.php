<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\PlantsRepository;

#[ORM\Entity(repositoryClass: PlantsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Plants
{
    use DateTimeTrait;
       
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\ManyToOne(inversedBy: 'plants', cascade: ['persist', 'remove'])]
    private ?UserPlants $userPlants = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
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
