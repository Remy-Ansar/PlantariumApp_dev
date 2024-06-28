<?php

namespace App\Entity;

use App\Repository\UserPlantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPlantsRepository::class)]
class UserPlants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userPlants')]
    private ?Users $User = null;

    /**
     * @var Collection<int, Plants>
     */
    #[ORM\OneToMany(targetEntity: Plants::class, mappedBy: 'userPlants')]
    private Collection $plants;

    public function __construct()
    {
        $this->plants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->User;
    }

    public function setUser(?Users $User): static
    {
        $this->User = $User;

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
            $plant->setUserPlants($this);
        }

        return $this;
    }

    public function removePlant(Plants $plant): static
    {
        if ($this->plants->removeElement($plant)) {
            // set the owning side to null (unless already changed)
            if ($plant->getUserPlants() === $this) {
                $plant->setUserPlants(null);
            }
        }

        return $this;
    }
}
