<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\PlantDetailWateringRepository;

#[ORM\Entity(repositoryClass: PlantDetailWateringRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PlantDetailWatering
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

    #[ORM\ManyToOne(inversedBy: 'PlantDetailWatering')]
    private ?Warnings $warnings = null;

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
}
