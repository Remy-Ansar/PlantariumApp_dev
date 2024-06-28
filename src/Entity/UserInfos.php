<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use Symfony\Component\HttpFoundation\File\File;
use App\Repository\UserInfosRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserInfosRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class UserInfos
{
    use DateTimeTrait;

    public const LEVEL =  ['Débutant', 'Intermédiaire', 'Expert'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    #[Assert\Length(max: 200)]

    private ?string $FirstName = null;

    #[ORM\Column(length: 200)]
    #[Assert\Length(max: 200)]
    private ?string $LastName = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    #[Assert\Choice(callback: [self::class, 'getAvailableLevels'])]
    private ?string $Level = null;

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

    #[ORM\OneToOne(targetEntity:"App\Entity\Users", mappedBy: 'UserInfos', cascade: ['persist', 'remove'])]
    private ?Users $users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(?string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(?string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->Level;
    }
    
    public function setLevel(?string $Level): static
    {
        $this->Level = $Level;
    
        return $this;
    }

    // Méthode pour obtenir les choix possibles (static pour être utilisée dans les assertions)
    public static function getAvailableLevels(): array
    {
    return ['Débutant', 'Intermédiaire', 'Expert'];
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        // unset the owning side of the relation if necessary
        if ($users === null && $this->users !== null) {
            $this->users->setUserInfos(null);
        }

        // set the owning side of the relation if necessary
        if ($users !== null && $users->getUserInfos() !== $this) {
            $users->setUserInfos($this);
        }

        $this->users = $users;

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

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getFullName(): string
    {
        return "$this->FirstName $this->LastName";
    }
    
}
