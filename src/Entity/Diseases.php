<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DiseasesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var Collection<int, PlantDetail>
     */
    #[ORM\ManyToMany(targetEntity: PlantDetail::class, inversedBy: 'diseases')]
    private Collection $PlantDetail;

    public function __construct()
    {

        $this->PlantDetail = new ArrayCollection();
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
     * @return Collection<int, PlantDetail>
     */
    public function getPlantDetail(): Collection
    {
        return $this->PlantDetail;
    }

    public function addPlantDetail(PlantDetail $plantDetail): self
    {
        if (!$this->PlantDetail->contains($plantDetail)) {
            $this->PlantDetail->add($plantDetail);
        }

        return $this;
    }

    public function removePlantDetail(PlantDetail $plantDetail): self
    {
        $this->PlantDetail->removeElement($plantDetail);

        return $this;
    }


}
