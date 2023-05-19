<?php

namespace App\Entity;

use App\Repository\ProfessionalTrainingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfessionalTrainingRepository::class)
 */
class ProfessionalTraining
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $training;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $establishment;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $month_start;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year_start;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $month_end;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year_end;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $this_day;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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

    /**
     * @ORM\ManyToOne(targetEntity=Curriculum::class)
     */
    private $curriculum;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTraining(): ?string
    {
        return $this->training;
    }

    public function setTraining(?string $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getEstablishment(): ?string
    {
        return $this->establishment;
    }

    public function setEstablishment(?string $establishment): self
    {
        $this->establishment = $establishment;

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

    public function getMonthStart(): ?int
    {
        return $this->month_start;
    }

    public function setMonthStart(?int $month_start): self
    {
        $this->month_start = $month_start;

        return $this;
    }

    public function getYearStart(): ?int
    {
        return $this->year_start;
    }

    public function setYearStart(?int $year_start): self
    {
        $this->year_start = $year_start;

        return $this;
    }

    public function getMonthEnd(): ?int
    {
        return $this->month_end;
    }

    public function setMonthEnd(?int $month_end): self
    {
        $this->month_end = $month_end;

        return $this;
    }

    public function getYearEnd(): ?int
    {
        return $this->year_end;
    }

    public function setYearEnd(?int $year_end): self
    {
        $this->year_end = $year_end;

        return $this;
    }

    public function isThisDay(): ?bool
    {
        return $this->this_day;
    }

    public function setThisDay(?bool $this_day): self
    {
        $this->this_day = $this_day;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    // public function getCurriculum(): ?Curriculum
    // {
    //     return $this->curriculum;
    // }

    // public function setCurriculum(?Curriculum $curriculum): self
    // {
    //     $this->curriculum = $curriculum;

    //     return $this;
    // }
}