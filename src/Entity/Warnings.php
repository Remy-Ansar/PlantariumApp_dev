<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\WarningsRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WarningsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Warnings
{
    use DateTimeTrait,
    EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    #[Assert\Length(max: 200)]
    #[Assert\NotBlank]
    private ?string $Name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    /**
     * @var Collection<int, Watering>
     */
    #[ORM\OneToMany(targetEntity: Watering::class, mappedBy: 'warnings')]
    private Collection $Watering;

    #[ORM\ManyToOne(inversedBy: 'warnings')]
    private ?Weather $Weather = null;

    /**
     * @var Collection<int, PlantDetailWatering>
     */
    #[ORM\OneToMany(targetEntity: PlantDetailWatering::class, mappedBy: 'warnings')]
    private Collection $PlantDetailWatering;

    /**
     * @var Collection<int, UserPlants>
     */
    #[ORM\ManyToMany(targetEntity: UserPlants::class, mappedBy: 'Warnings')]
    private Collection $userPlants;

    /**
     * @var Collection<int, PlantDetail>
     */
    #[ORM\ManyToMany(targetEntity: PlantDetail::class, mappedBy: 'Warnings')]
    private Collection $plantDetails;

    public function __construct()
    {
        $this->Watering = new ArrayCollection();
        $this->PlantDetailWatering = new ArrayCollection();
        $this->userPlants = new ArrayCollection();
        $this->plantDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Text): static
    {
        $this->Description = $Text;

        return $this;
    }


    /**
     * @return Collection<int, Watering>
     */
    public function getWatering(): Collection
    {
        return $this->Watering;
    }

    public function addWatering(Watering $watering): static
    {
        if (!$this->Watering->contains($watering)) {
            $this->Watering->add($watering);
            $watering->setWarnings($this);
        }

        return $this;
    }

    public function removeWatering(Watering $watering): static
    {
        if ($this->Watering->removeElement($watering)) {
            // set the owning side to null (unless already changed)
            if ($watering->getWarnings() === $this) {
                $watering->setWarnings(null);
            }
        }

        return $this;
    }

    public function getWeather(): ?Weather
    {
        return $this->Weather;
    }

    public function setWeather(?Weather $Weather): static
    {
        $this->Weather = $Weather;

        return $this;
    }

    /**
     * @return Collection<int, PlantDetailWatering>
     */
    public function getPlantDetailWatering(): Collection
    {
        return $this->PlantDetailWatering;
    }

    public function addPlantDetailWatering(PlantDetailWatering $plantDetailWatering): static
    {
        if (!$this->PlantDetailWatering->contains($plantDetailWatering)) {
            $this->PlantDetailWatering->add($plantDetailWatering);
            $plantDetailWatering->setWarnings($this);
        }

        return $this;
    }

    public function removePlantDetailWatering(PlantDetailWatering $plantDetailWatering): static
    {
        if ($this->PlantDetailWatering->removeElement($plantDetailWatering)) {
            // set the owning side to null (unless already changed)
            if ($plantDetailWatering->getWarnings() === $this) {
                $plantDetailWatering->setWarnings(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserPlants>
     */
    public function getUserPlants(): Collection
    {
        return $this->userPlants;
    }

    public function addUserPlant(UserPlants $userPlant): static
    {
        if (!$this->userPlants->contains($userPlant)) {
            $this->userPlants->add($userPlant);
            $userPlant->addWarning($this);
        }

        return $this;
    }

    public function removeUserPlant(UserPlants $userPlant): static
    {
        if ($this->userPlants->removeElement($userPlant)) {
            $userPlant->removeWarning($this);
        }

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
            $plantDetail->addWarning($this);
        }

        return $this;
    }

    public function removePlantDetail(PlantDetail $plantDetail): static
    {
        if ($this->plantDetails->removeElement($plantDetail)) {
            $plantDetail->removeWarning($this);
        }

        return $this;
    }
}
