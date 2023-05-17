<?php

namespace App\Entity;

use App\Repository\PersonalInformationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonalInformationRepository::class)
 */
class PersonalInformation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datenaiss;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lieudenaiss;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $driver_license;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $marital_status;

    /**
     * @ORM\OneToMany(targetEntity=CustomFieldInformation::class, mappedBy="personalInformation", orphanRemoval=true)
     */
    private $customFieldInformation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_deleted;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    

  

    public function __construct()
    {
        $this->customFieldInformation = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(?string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getMaritalStatus(): ?string
    {
        return $this->marital_status;
    }

    public function setMaritalStatus(?string $marital_status): self
    {
        $this->marital_status = $marital_status;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getLieudenaiss(): ?string
    {
        return $this->lieudenaiss;
    }

    public function setLieudenaiss(string $lieudenaiss): self
    {
        $this->lieudenaiss = $lieudenaiss;

        return $this;
    }

    public function getDriverLicense(): ?string
    {
        return $this->driver_license;
    }

    public function setDriverLicense(?string $driver_license): self
    {
        $this->driver_license = $driver_license;

        return $this;
    }

    /**
     * @return Collection<int, CustomFieldInformation>
     */
    public function getCustomFieldInformation(): Collection
    {
        return $this->customFieldInformation;
    }

    public function addCustomFieldInformation(CustomFieldInformation $customFieldInformation): self
    {
        if (!$this->customFieldInformation->contains($customFieldInformation)) {
            $this->customFieldInformation[] = $customFieldInformation;
            $customFieldInformation->setPersonalInformation($this);
        }

        return $this;
    }

    public function removeCustomFieldInformation(CustomFieldInformation $customFieldInformation): self
    {
        if ($this->customFieldInformation->removeElement($customFieldInformation)) {
            // set the owning side to null (unless already changed)
            if ($customFieldInformation->getPersonalInformation() === $this) {
                $customFieldInformation->setPersonalInformation(null);
            }
        }

        return $this;
    }
}