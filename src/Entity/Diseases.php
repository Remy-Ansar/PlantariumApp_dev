<?php

namespace App\Entity;

use App\Repository\DiseasesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiseasesRepository::class)]
class Diseases
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    /**
     * @var Collection<int, HealthStatus>
     */
    #[ORM\OneToMany(targetEntity: HealthStatus::class, mappedBy: 'Diseases')]
    private Collection $healthStatuses;

    public function __construct()
    {
        $this->healthStatuses = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, HealthStatus>
     */
    public function getHealthStatuses(): Collection
    {
        return $this->healthStatuses;
    }

    public function addHealthStatus(HealthStatus $healthStatus): static
    {
        if (!$this->healthStatuses->contains($healthStatus)) {
            $this->healthStatuses->add($healthStatus);
            $healthStatus->setDiseases($this);
        }

        return $this;
    }

    public function removeHealthStatus(HealthStatus $healthStatus): static
    {
        if ($this->healthStatuses->removeElement($healthStatus)) {
            // set the owning side to null (unless already changed)
            if ($healthStatus->getDiseases() === $this) {
                $healthStatus->setDiseases(null);
            }
        }

        return $this;
    }
}
