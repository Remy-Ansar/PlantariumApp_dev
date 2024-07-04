<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'UNIQ_NAME_CATEGORY', columns: ['Name'])]
#[UniqueEntity(fields: ['Name'], message: 'Cette catégorie existe déjà.')]
class Categories
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
    #[ORM\ManyToMany(targetEntity: Plants::class, inversedBy: 'categories')]
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
        }

        return $this;
    }

    public function removePlant(Plants $plant): static
    {
        $this->Plants->removeElement($plant);

        return $this;
    }

}
