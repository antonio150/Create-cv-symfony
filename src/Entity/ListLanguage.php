<?php

namespace App\Entity;

use App\Repository\ListLanguageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListLanguageRepository::class)
 */
class ListLanguage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Language::class, cascade={"persist", "remove"})
     */
    private $id_language;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note_language;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity=Curriculum::class, inversedBy="id_langue")
     */
    private $id_cv;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLanguage(): ?Language
    {
        return $this->id_language;
    }

    public function setIdLanguage(?Language $id_language): self
    {
        $this->id_language = $id_language;

        return $this;
    }

    public function getNoteLanguage(): ?int
    {
        return $this->note_language;
    }

    public function setNoteLanguage(?int $note_language): self
    {
        $this->note_language = $note_language;

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

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

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