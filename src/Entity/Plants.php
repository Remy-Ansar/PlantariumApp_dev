<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\PlantsRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\HttpFoundation\File\File;


#[ORM\Entity(repositoryClass: PlantsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Plants
{
    use DateTimeTrait;
    use EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 180)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 180)]
    private ?string $LatinName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'plants')]
    private ?UserPlants $userPlants = null;

    #[Vich\UploadableField(mapping: 'profile', fileNameProperty: 'imageName')]
    #[Assert\Image(
        mimeTypes: ['image/*'],
        maxSize: '8M',
        detectCorrupted: true,
    )]
    // #[Assert\NotBlank()]
    
    private ?File $image = null;

    #[ORM\Column(length:255, nullable:true)]
    #[Groups(['product:read'])]
    private ?string $imageName = null;

    /**
     * @var Collection<int, Seasons>
     */
    #[ORM\ManyToMany(targetEntity: Seasons::class, mappedBy: 'plants')]
    private Collection $seasons;

    #[ORM\ManyToOne(inversedBy: 'Plants')]
    private ?Families $families = null;

    #[ORM\ManyToOne(inversedBy: 'Plants')]
    private ?Species $species = null;

    /**
     * @var Collection<int, Categories>
     */
    #[ORM\ManyToMany(targetEntity: Categories::class, mappedBy: 'Plants')]
    private Collection $categories;

    /**
     * @var Collection<int, Colors>
     */
    #[ORM\ManyToMany(targetEntity: Colors::class, mappedBy: 'Plants')]
    private Collection $colors;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->colors = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getUserPlants(): ?UserPlants
    {
        return $this->userPlants;
    }

    public function setUserPlants(?UserPlants $userPlants): static
    {
        $this->userPlants = $userPlants;

        return $this;
    }

    /**
     * @return Collection<int, Seasons>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Seasons $season): static
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->addPlant($this);
        }

        return $this;
    }

    public function removeSeason(Seasons $season): static
    {
        if ($this->seasons->removeElement($season)) {
            $season->removePlant($this);
        }

        return $this;
    }

    public function getFamilies(): ?Families
    {
        return $this->families;
    }

    public function setFamilies(?Families $families): static
    {
        $this->families = $families;

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): static
    {
        $this->species = $species;

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addPlant($this);
        }

        return $this;
    }

    public function removeCategory(Categories $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removePlant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Colors>
     */
    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function addColor(Colors $color): static
    {
        if (!$this->colors->contains($color)) {
            $this->colors->add($color);
            $color->addPlant($this);
        }

        return $this;
    }

    public function removeColor(Colors $color): static
    {
        if ($this->colors->removeElement($color)) {
            $color->removePlant($this);
        }

        return $this;
    }

    /**
     * Get the value of LatinName
     *
     * @return ?string
     */
    public function getLatinName(): ?string
    {
        return $this->LatinName;
    }

    /**
     * Set the value of LatinName
     *
     * @param ?string $LatinName
     *
     * @return self
     */
    public function setLatinName(?string $LatinName): self
    {
        $this->LatinName = $LatinName;

        return $this;
    }

    public function setImage(?File $imageFile = null): static
    {
        $this->image = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }


}
