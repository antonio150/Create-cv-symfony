<?php

namespace App\Entity;

use App\Repository\CustomFieldInformationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomFieldInformationRepository::class)
 */
class CustomFieldInformation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=PersonalInformation::class)
     */
   
    private $field_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $field_contents;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_deleted;

    /**
     * @ORM\ManyToOne(targetEntity=PersonalInformation::class, inversedBy="customFieldInformation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personalInformation;

  
    

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getFieldName(): ?string
    {
        return $this->field_name;
    }

    public function setFieldName(?string $field_name): self
    {
        $this->field_name = $field_name;

        return $this;
    }

    public function getFieldContents(): ?string
    {
        return $this->field_contents;
    }

    public function setFieldContents(?string $field_contents): self
    {
        $this->field_contents = $field_contents;

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

    public function isIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(?bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

    public function getPersonalInformation(): ?PersonalInformation
    {
        return $this->personalInformation;
    }

    public function setPersonalInformation(?PersonalInformation $personalInformation): self
    {
        $this->personalInformation = $personalInformation;

        return $this;
    }
}