<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use App\Repository\HealthStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HealthStatusRepository::class)]
class HealthStatus
{
    use DateTimeTrait;

    public const STATUS = ['En bonne santé', 'Malade', 'Morte'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    #[Assert\Choice(callback: [self::class, 'getAvailableStatus'])]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'healthStatuses')]
    private ?Diseases $Diseases = null;

    /**
     * @var Collection<int, PlantDetail>
     */
    #[ORM\OneToMany(targetEntity: PlantDetail::class, mappedBy: 'HealthStatus')]
    private Collection $plantDetails;

    public function __construct()
    {
        $this->plantDetails = new ArrayCollection();
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

    public function setStatus(?string $Status): static
    {
        $this->Name = $Status;

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

    public function getDiseases(): ?Diseases
    {
        return $this->Diseases;
    }

    public function setDiseases(?Diseases $Diseases): static
    {
        $this->Diseases = $Diseases;

        return $this;
    }

    /**
     * @return Collection<int, PlantDetail>
     */
    public function getPlantDetails(): Collection
    {
        return $this->plantDetails;
    }

    public function addPlantDetail(PlantDetail $plantDetail): static
    {
        if (!$this->plantDetails->contains($plantDetail)) {
            $this->plantDetails->add($plantDetail);
            $plantDetail->setHealthStatus($this);
        }

        return $this;
    }

    public function removePlantDetail(PlantDetail $plantDetail): static
    {
        if ($this->plantDetails->removeElement($plantDetail)) {
            // set the owning side to null (unless already changed)
            if ($plantDetail->getHealthStatus() === $this) {
                $plantDetail->setHealthStatus(null);
            }
        }

        return $this;
    }

    // Méthode pour obtenir les choix possibles (static pour être utilisée dans les assertions)
    public static function getAvailableStatus(): array
    {
    return ['En bonne santé', 'Malade', 'Morte'];
    }
}
