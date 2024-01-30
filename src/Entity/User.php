<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
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

    //password
    #[ORM\Column]
    #[Assert\NotBlank(
        message: 'Le mot de passe ne peut pas être vide.'
    )]
    #[Assert\Length(
        min: 8,
        max: 4096, // Longueur maximale pour éviter des attaques de déni de service
        minMessage: 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Votre mot de passe ne peut pas contenir plus de {{ limit }} caractères.'
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
    private ?string $password;

    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];


    #[ORM\Column(length: 255)]
    private ?string $link_hub = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getusername(): ?string
    {
        return $this->username;
    }

    public function setusername(string $username): static
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

    public function getLinkHub(): ?string
    {
        return $this->link_hub;
    }

    public function setLinkHub(string $link_hub): static
    {
        $this->link_hub = $link_hub;

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
    public function getPassword()
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
}
