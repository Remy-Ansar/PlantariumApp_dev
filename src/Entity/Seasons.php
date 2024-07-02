<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\SeasonsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeasonsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Seasons
{
    use DateTimeTrait;

    public const SEASONS = ['Printemps', 'Eté', 'Automne', 'Hiver'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    #[Assert\Choice(callback: [self::class, 'getAvailableSeasons'])]
    private ?string $Name = null;

    /**
     * @var Collection<int, Plants>
     */
    #[ORM\ManyToMany(targetEntity: Plants::class, inversedBy: 'seasons')]
    private Collection $plants;

    public function __construct()
    {
        $this->plants = new ArrayCollection();
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
        return $this->plants;
    }

    public function addPlant(Plants $plant): static
    {
        if (!$this->plants->contains($plant)) {
            $this->plants->add($plant);
        }

        return $this;
    }

    public function removePlant(Plants $plant): static
    {
        $this->plants->removeElement($plant);

        return $this;
    }

    

    // Méthode pour obtenir les choix possibles (static pour être utilisée dans les assertions)
    public static function getAvailableSeasons(): array
    {
    return ['Printemps', 'Eté', 'Automne', 'Hiver'];
    }
}
