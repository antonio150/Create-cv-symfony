<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
    private $training;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $establishment;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $month_start;

    /**
     * @ORM\Column(type="integer")
     */
    private $year_start;

    /**
     * @ORM\Column(type="integer")
     */
    private $month_end;

    /**
     * @ORM\Column(type="integer")
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
    private $deleted;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Curriculum::class, inversedBy="id_formation")
     */
    private $id_cv;

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

    public function setMonthStart(int $month_start): self
    {
        $this->month_start = $month_start;

        return $this;
    }

    public function getYearStart(): ?int
    {
        return $this->year_start;
    }

    public function setYearStart(int $year_start): self
    {
        $this->year_start = $year_start;

        return $this;
    }

    public function getMonthEnd(): ?int
    {
        return $this->month_end;
    }

    public function setMonthEnd(int $month_end): self
    {
        $this->month_end = $month_end;

        return $this;
    }

    public function getYearEnd(): ?int
    {
        return $this->year_end;
    }

    public function setYearEnd(int $year_end): self
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

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getIdCv(): ?Curriculum
    {
        return $this->id_cv;
    }

    public function setIdCv(?Curriculum $id_cv): self
    {
        $this->id_cv = $id_cv;

        return $this;
    }
}