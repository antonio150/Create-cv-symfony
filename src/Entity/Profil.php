<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_deleted;

    // /**
    //  * @ORM\ManyToOne(targetEntity=Curriculum::class, nullable=true)
    //  */
    // private $curriculum;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToOne(targetEntity=Curriculum::class, mappedBy="id_profil", cascade={"persist", "remove"})
     */
    private $id_cv;

    public function getId(): ?int
    {
        return $this->id;
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

    // public function getCurriculum(): ?Curriculum
    // {
    //     return $this->curriculum;
    // }

    // public function setCurriculum(?Curriculum $curriculum): self
    // {
    //     $this->curriculum = $curriculum;

    //     return $this;
    // }

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
        // unset the owning side of the relation if necessary
        if ($id_cv === null && $this->id_cv !== null) {
            $this->id_cv->setIdProfil(null);
        }

        // set the owning side of the relation if necessary
        if ($id_cv !== null && $id_cv->getIdProfil() !== $this) {
            $id_cv->setIdProfil($this);
        }

        $this->id_cv = $id_cv;

        return $this;
    }
}