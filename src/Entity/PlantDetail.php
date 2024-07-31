<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Diseases>
     */
    #[ORM\ManyToMany(targetEntity: Diseases::class, mappedBy: 'PlantDetail')]
    private Collection $diseases;


    #[ORM\ManyToOne(targetEntity: HealthStatus::class, inversedBy: 'plantDetails')]
    private ?HealthStatus $HealthStatus = null;

    public function __construct()
    {
        $this->diseases = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Diseases>
     */
    public function getDiseases(): Collection
    {
        return $this->diseases;
    }

    public function addDisease(Diseases $disease): static
    {
        if (!$this->diseases->contains($disease)) {
            $this->diseases->add($disease);
            $disease->addPlantDetail($this);
        }

        return $this;
    }

    public function removeDisease(Diseases $disease): static
    {
        if ($this->diseases->removeElement($disease)) {
            $disease->removePlantDetail($this);
        }

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
    
    /**
     * Set the value of diseases
     *
     * @param Collection $diseases
     *
     * @return self
     */
    public function setDiseases(Collection $diseases): self
    {
        $this->diseases = $diseases;

        return $this;
    }
}
