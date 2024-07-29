<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\PlantDetailRepository;

#[ORM\Entity(repositoryClass: PlantDetailRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PlantDetail
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Journal = null;

    #[ORM\ManyToOne(targetEntity: UserPlants::class, inversedBy: 'plantDetails',  cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserPlants $userPlants = null;


    #[ORM\ManyToOne(inversedBy: 'plantDetails')]
    private ?Plants $Plant = null;

    #[ORM\ManyToOne(inversedBy: 'plantDetails', cascade: ['persist'])]
    private ?HealthStatus $HealthStatus = null;

    #[ORM\ManyToOne(targetEntity: Diseases::class, inversedBy: 'plantDetails')]
    private ?Diseases $Diseases = null;

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

    public function getDiseases(): ?Diseases
    {
        return $this->Diseases;
    }

    public function setDiseases(?Diseases $Diseases): static
    {
        $this->Diseases = $Diseases;
        return $this;
    }
}
