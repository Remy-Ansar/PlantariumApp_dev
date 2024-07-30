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
     * @var Plants<int, Plants>
     */
    #[ORM\ManyToOne(targetEntity: Plants::class, inversedBy: 'userPlants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Plants $plant = null;

    /**
     * @var Collection<int, PlantDetail>
     */
    #[ORM\OneToMany(targetEntity: PlantDetail::class, mappedBy: 'userPlants', cascade: ['persist'])]
    private Collection $plantDetail;

    public function __construct()
    {
        $this->plantDetail = new ArrayCollection();
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
    
    public function getPlant(): ?Plants
    {
        return $this->plant;
    }

    public function setPlant(?Plants $plant): self
    {
        $this->plant = $plant;
        return $this;
    }

    /**
     * @return Collection<int, PlantDetail>
     */
    public function getPlantDetails(): Collection
    {
        return $this->plantDetail;
    }

    public function addPlantDetail(PlantDetail $plantDetail): static
    {
        if (!$this->plantDetail->contains($plantDetail)) {
            $this->plantDetail->add($plantDetail);
            $plantDetail->setUserPlants($this);
        }

        return $this;
    }

    public function removePlantDetail(PlantDetail $plantDetail): static
    {
        if ($this->plantDetail->removeElement($plantDetail)) {
            // set the owning side to null (unless already changed)
            if ($plantDetail->getUserPlants() === $this) {
                $plantDetail->setUserPlants(null);
            }
        }

        return $this;
    }


}
