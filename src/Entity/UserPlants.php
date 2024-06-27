<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use App\Repository\UserPlantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPlantsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class UserPlants
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'userPlants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

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

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

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
