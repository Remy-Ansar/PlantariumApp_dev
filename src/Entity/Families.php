<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\FamiliesRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: FamiliesRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_NAME_FAMILY', columns: ['Name'])]
#[UniqueEntity(fields: ['Name'], message: 'Cette famille de plante existe déjà')]
#[ORM\HasLifecycleCallbacks]
class Families
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
    #[ORM\OneToMany(targetEntity: Plants::class, mappedBy: 'families')]
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
            $plant->setFamilies($this);
        }

        return $this;
    }

    public function removePlant(Plants $plant): static
    {
        if ($this->Plants->removeElement($plant)) {
            // set the owning side to null (unless already changed)
            if ($plant->getFamilies() === $this) {
                $plant->setFamilies(null);
            }
        }

        return $this;
    }
}
