<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\WateringRepository;

#[ORM\Entity(repositoryClass: WateringRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Watering
{
    use DateTimeTrait;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Note = null;

    #[ORM\Column(nullable: true)]
    private ?int $Frequency = null;

    #[ORM\Column(nullable: true)]
    private ?float $Quantity = null;

    #[ORM\ManyToOne(inversedBy: 'Watering')]
    private ?Warnings $warnings = null;

    /**
     * @var Collection<int, Plants>
     */
    #[ORM\OneToMany(targetEntity: Plants::class, mappedBy: 'Watering')]
    private Collection $plants;

    public function __construct()
    {
        $this->plants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->Note;
    }

    public function setNote(?string $Note): static
    {
        $this->Note = $Note;

        return $this;
    }

    public function getFrequency(): ?int
    {
        return $this->Frequency;
    }

    public function setFrequency(?int $Frequency): static
    {
        $this->Frequency = $Frequency;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->Quantity;
    }

    public function setQuantity(?float $Quantity): static
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getWarnings(): ?Warnings
    {
        return $this->warnings;
    }

    public function setWarnings(?Warnings $warnings): static
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * @return Collection<int, Plants>
     */
    public function getPlants(): Collection
    {
        return $this->plants;
    }

    public function addPlant(Plants $plant): static
    {
        if (!$this->plants->contains($plant)) {
            $this->plants->add($plant);
            $plant->setWatering($this);
        }

        return $this;
    }

    public function removePlant(Plants $plant): static
    {
        if ($this->plants->removeElement($plant)) {

            if ($plant->getWatering() === $this) {
                $plant->setWatering(null);
            }
        }

        return $this;
    }
}
