<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use App\Repository\ColorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ColorsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Colors
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $Name = null;

    /**
     * @var Collection<int, Plants>
     */
    #[ORM\ManyToMany(targetEntity: Plants::class, inversedBy: 'colors')]
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
