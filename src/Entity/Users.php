<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\UsersRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé par un autre compte')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\Length(max: 180)]
    #[Assert\NotBlank()]
    #[Assert\Email]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(targetEntity: UserInfos::class, inversedBy: "users", cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "user_infos_id", referencedColumnName: "id")]
    private ?UserInfos $UserInfos = null;

    /**
     * @var Collection<int, UserPlants>
     */
    #[ORM\OneToMany(targetEntity: UserPlants::class, mappedBy: 'Users_id', cascade: ['persist', 'remove'])]
    private Collection $userPlants;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
   

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->userPlants = new ArrayCollection();
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserInfos(): ?UserInfos
    {
        return $this->UserInfos;
    }

    public function setUserInfos(?UserInfos $UserInfos): static
    {
        $this->UserInfos = $UserInfos;

        return $this;
    }

    public function getFullName(): ?string
    {
        if ($this->UserInfos) {
            return $this->UserInfos->getFirstName() . ' ' . $this->UserInfos->getLastName();
        }
        return null;
    }

    public function getUserLevel(): ?string
    {
        if ($this->UserInfos) {
            return $this->UserInfos->getLevel();
        }
        return null;
    }

    /**
     * @return Collection<int, UserPlants>
     */
    public function getUserPlants(): Collection
    {
        return $this->userPlants;
    }

    public function addUserPlant(UserPlants $userPlant): static
    {
        if (!$this->userPlants->contains($userPlant)) {
            $this->userPlants->add($userPlant);
            $userPlant->setUser($this);
        }

        return $this;
    }

    public function removeUserPlant(UserPlants $userPlant): static
    {
        if ($this->userPlants->removeElement($userPlant)) {
            // set the owning side to null (unless already changed)
            if ($userPlant->getUser() === $this) {
                $userPlant->setUser(null);
            }
        }

        return $this;
    }
}