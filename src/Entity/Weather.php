<?php

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WeatherRepository::class)]
class Weather
{
    public const WeatherConditions = ['Rien à signaler', 'Canicule', 'Vague de froid'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    /**
     * @var Collection<int, Warnings>
     */
    #[ORM\OneToMany(targetEntity: Warnings::class, mappedBy: 'Weather')]
    private Collection $warnings;

    public function __construct()
    {
        $this->warnings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Warnings>
     */
    public function getWarnings(): Collection
    {
        return $this->warnings;
    }

    public function addWarning(Warnings $warning): static
    {
        if (!$this->warnings->contains($warning)) {
            $this->warnings->add($warning);
            $warning->setWeather($this);
        }

        return $this;
    }

    public function removeWarning(Warnings $warning): static
    {
        if ($this->warnings->removeElement($warning)) {
            // set the owning side to null (unless already changed)
            if ($warning->getWeather() === $this) {
                $warning->setWeather(null);
            }
        }

        return $this;
    }

        // Méthode pour obtenir les choix possibles (static pour être utilisée dans les assertions)
        public static function getAvailableWeatherConditions(): array
        {
        return ['Rien à signaler', 'Canicule', 'Vague de froid'];
        }
}
