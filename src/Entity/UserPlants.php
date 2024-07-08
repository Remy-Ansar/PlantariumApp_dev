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
    private ?Users $User = null;

    /**
     * @var Collection<int, Plants>
     */
    #[ORM\ManyToOne(targetEntity: Plants::class, inversedBy: 'userPlants')]
    #[ORM\JoinColumn(nullable: false)]
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

    public function setUser(?Users $User): self
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

    public function setPlant(Plants $plant): self
    {
        $this->plants = $plant;

        return $this;
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
