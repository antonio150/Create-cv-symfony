<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    private $_passwordEncoder;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $first_name;

    // /**
    //  * @ORM\Column(type="string", length=20, nullable=true)
    //  */
    // private $type;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_deleted;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_blocked;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     *
     */
    private $plainPassword;

    /**
     * @ORM\ManyToOne(targetEntity=UserType::class)
     */
    private $user_type;

    /**
     * @ORM\ManyToOne(targetEntity=Contract::class)
     */
    private $contract;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';


        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
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
    }
    
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __construct($username, $password, $name, $firstName, $adresse, UserType $userType)
    {
        switch($userType->getId()) {
            case 1:
                $this->roles = ["ROLE_ADMIN"];
                break;
            case 3:
                $this->roles = ["ROLE_CLIENT"];
                break;
            case 2:
                $this->roles = ["ROLE_USER"];
                break;
        }

        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->first_name = $firstName;
        $this->adresse = $adresse;
        $this->is_deleted = false;
        $this->createdAt = new DateTime();
        $this->is_blocked = false;
        $this->user_type = $userType;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(?bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsBlocked(): ?bool
    {
        return $this->is_blocked;
    }

    public function setIsBlocked(?bool $is_blocked): self
    {
        $this->is_blocked = $is_blocked;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setBaseAttributes($data, UserType $userType)
    {
        $name = isset($data["name"]) ? $data["name"] : NULL;
        $firstName = isset($data["firstName"]) ? $data["firstName"] : NULL;
        $adresse = isset($data["adresse"]) ? $data["adresse"] : NULL;
        $username = isset($data["username"]) ? $data["username"] : NULL;
        $id = isset($data["id"]) ? $data["id"] : NULL;

        switch($userType->getId()) {
            case 1:
                $this->roles = ["ROLE_ADMIN"];
                break;
            case 3:
                $this->roles = ["ROLE_CLIENT"];
                break;
            case 2:
                $this->roles = ["ROLE_USER"];
                break;
        }

        $this->username = $username;
        $this->name = $name;
        $this->first_name = $firstName;
        $this->adresse = $adresse;
        $this->id = $id;
        $this->updatedAt = new DateTime();
        $this->user_type = $userType;
    }

    public function getUserType(): ?UserType
    {
        return $this->user_type;
    }

    public function setUserType(?UserType $user_type): self
    {
        $this->user_type = $user_type;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;

        return $this;
    }
}
