<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints\GitHubConstraint;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 3, max: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Length(min: 5, max: 100)]
    #[Assert\Email]
    private ?string $email = null;

    #[Assert\Regex(
        pattern: '/[A-Z]/',
        message: 'Votre mot de passe doit contenir au moins une lettre majuscule.'
    )]
    private ?string $plainPassword = null;

    //password
    #[ORM\Column]
    #[Assert\NotBlank(
        message: 'Le mot de passe ne peut pas être vide.'
    )]
    #[Assert\Length(
        min: 8,
        max: 4096, // Longueur maximale pour éviter des attaques de déni de service
        minMessage: 'Votre mot de passe doit contenir minimum 8 caractères.'
    )]
    #[Assert\Regex(
        pattern: '/[A-Z]/',
        message: 'Votre mot de passe doit contenir au moins une lettre majuscule.'
    )]
    #[Assert\Regex(
        pattern: '/[a-z]/',
        message: 'Votre mot de passe doit contenir au moins une lettre minuscule.'
    )]
    #[Assert\Regex(
        pattern: '/[0-9]/',
        message: 'Votre mot de passe doit contenir au moins un chiffre.'
    )]
    #[Assert\Regex(
        pattern: '/[\W]/',
        message: 'Votre mot de passe doit contenir au moins un caractère spécial.'
    )]
    //ici on doit bien respecter les contraintes avec la valeur, qui peut pas etre 'null' ou '123" 
    private ?string $password = "Initialized1!";

    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: GitLink::class)]
    private Collection $gitLinks;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->gitLinks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Get the value of username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }


    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }
    /**
     * Get the value of roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */
    public function setRoles($roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return Collection<int, GitLink>
     */
    public function getGitLinks(): Collection
    {
        return $this->gitLinks;
    }

    public function addGitLink(GitLink $gitLink): static
    {
        if (!$this->gitLinks->contains($gitLink)) {
            $this->gitLinks->add($gitLink);
            $gitLink->setUser($this);
        }

        return $this;
    }

    public function removeGitLink(GitLink $gitLink): static
    {
        if ($this->gitLinks->removeElement($gitLink)) {
            // set the owning side to null (unless already changed)
            if ($gitLink->getUser() === $this) {
                $gitLink->setUser(null);
            }
        }

        return $this;
    }
}
