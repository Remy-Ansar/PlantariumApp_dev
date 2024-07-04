<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\SpeciesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SpeciesRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'UNIQ_NAME_SPECIES', columns: ['Name'])]
#[UniqueEntity(fields: ['Name'], message: 'Cette espèce de plante existe déjà.')]
class Species
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    #[Gedmo\Slug(fields: ['Name'], unique: true)]
    private ?string $Name = null;

    /**
     * @var Collection<int, Plants>
     */
    #[ORM\OneToMany(targetEntity: Plants::class, mappedBy: 'species')]
    private Collection $Plants;

    public function __construct()
    {
        $this->Plants = new ArrayCollection();
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

    /**
     * @return Collection<int, Plants>
     */
    public function getPlants(): Collection
    {
        return $this->Plants;
    }

    public function addPlant(Plants $plant): static
    {
        if (!$this->Plants->contains($plant)) {
            $this->Plants->add($plant);
            $plant->setSpecies($this);
        }

        return $this;
    }

    public function removePlant(Plants $plant): static
    {
        if ($this->Plants->removeElement($plant)) {
            // set the owning side to null (unless already changed)
            if ($plant->getSpecies() === $this) {
                $plant->setSpecies(null);
            }
        }

        return $this;
    }
}
