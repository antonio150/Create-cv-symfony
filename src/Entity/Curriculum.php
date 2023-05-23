<?php

namespace App\Entity;

use App\Repository\CurriculumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurriculumRepository::class)
 */
class Curriculum
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
    private $personalInformation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToOne(targetEntity=Profil::class, inversedBy="id_cv", cascade={"persist", "remove"})
     */
    private $id_profil;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     */
    private $id_user;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="id_cv")
     */
    private $id_formation;

    /**
     * @ORM\OneToMany(targetEntity=ProfessionalExperience::class, mappedBy="id_cv")
     */
    private $id_experience;

    /**
     * @ORM\OneToMany(targetEntity=CenterOfInterest::class, mappedBy="id_cv")
     */
    private $id_interet;

    /**
     * @ORM\OneToMany(targetEntity=Reference::class, mappedBy="id_cv")
     */
    private $id_reference;

    /**
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="id_cv")
     */
    private $id_skill;

    /**
     * @ORM\OneToMany(targetEntity=ListLanguage::class, mappedBy="id_cv")
     */
    private $id_langue;

    /**
     * @ORM\OneToOne(targetEntity=BasDePage::class, cascade={"persist", "remove"})
     */
    private $id_bas_de_page;

    /**
     * @ORM\ManyToOne(targetEntity=ProfessionalTraining::class, inversedBy="id_cv")
     */
    private $id_training;

    public function __construct()
    {
        $this->id_formation = new ArrayCollection();
        $this->id_experience = new ArrayCollection();
        $this->id_interet = new ArrayCollection();
        $this->id_reference = new ArrayCollection();
        $this->id_skill = new ArrayCollection();
        $this->id_langue = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdProfil(): ?Profil
    {
        return $this->id_profil;
    }

    public function setIdProfil(?Profil $id_profil): self
    {
        $this->id_profil = $id_profil;

        return $this;
    }

    public function getIdUser(): ?Utilisateur
    {
        return $this->id_user;
    }

    public function setIdUser(?Utilisateur $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getIdFormation(): Collection
    {
        return $this->id_formation;
    }

    public function addIdFormation(Formation $idFormation): self
    {
        if (!$this->id_formation->contains($idFormation)) {
            $this->id_formation[] = $idFormation;
            $idFormation->setIdCv($this);
        }

        return $this;
    }

    public function removeIdFormation(Formation $idFormation): self
    {
        if ($this->id_formation->removeElement($idFormation)) {
            // set the owning side to null (unless already changed)
            if ($idFormation->getIdCv() === $this) {
                $idFormation->setIdCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProfessionalExperience>
     */
    public function getIdExperience(): Collection
    {
        return $this->id_experience;
    }

    public function addIdExperience(ProfessionalExperience $idExperience): self
    {
        if (!$this->id_experience->contains($idExperience)) {
            $this->id_experience[] = $idExperience;
            $idExperience->setIdCv($this);
        }

        return $this;
    }

    public function removeIdExperience(ProfessionalExperience $idExperience): self
    {
        if ($this->id_experience->removeElement($idExperience)) {
            // set the owning side to null (unless already changed)
            if ($idExperience->getIdCv() === $this) {
                $idExperience->setIdCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CenterOfInterest>
     */
    public function getIdInteret(): Collection
    {
        return $this->id_interet;
    }

    public function addIdInteret(CenterOfInterest $idInteret): self
    {
        if (!$this->id_interet->contains($idInteret)) {
            $this->id_interet[] = $idInteret;
            $idInteret->setIdCv($this);
        }

        return $this;
    }

    public function removeIdInteret(CenterOfInterest $idInteret): self
    {
        if ($this->id_interet->removeElement($idInteret)) {
            // set the owning side to null (unless already changed)
            if ($idInteret->getIdCv() === $this) {
                $idInteret->setIdCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reference>
     */
    public function getIdReference(): Collection
    {
        return $this->id_reference;
    }

    public function addIdReference(Reference $idReference): self
    {
        if (!$this->id_reference->contains($idReference)) {
            $this->id_reference[] = $idReference;
            $idReference->setIdCv($this);
        }

        return $this;
    }

    public function removeIdReference(Reference $idReference): self
    {
        if ($this->id_reference->removeElement($idReference)) {
            // set the owning side to null (unless already changed)
            if ($idReference->getIdCv() === $this) {
                $idReference->setIdCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getIdSkill(): Collection
    {
        return $this->id_skill;
    }

    public function addIdSkill(Skill $idSkill): self
    {
        if (!$this->id_skill->contains($idSkill)) {
            $this->id_skill[] = $idSkill;
            $idSkill->setIdCv($this);
        }

        return $this;
    }

    public function removeIdSkill(Skill $idSkill): self
    {
        if ($this->id_skill->removeElement($idSkill)) {
            // set the owning side to null (unless already changed)
            if ($idSkill->getIdCv() === $this) {
                $idSkill->setIdCv(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ListLanguage>
     */
    public function getIdLangue(): Collection
    {
        return $this->id_langue;
    }

    public function addIdLangue(ListLanguage $idLangue): self
    {
        if (!$this->id_langue->contains($idLangue)) {
            $this->id_langue[] = $idLangue;
            $idLangue->setIdCv($this);
        }

        return $this;
    }

    public function removeIdLangue(ListLanguage $idLangue): self
    {
        if ($this->id_langue->removeElement($idLangue)) {
            // set the owning side to null (unless already changed)
            if ($idLangue->getIdCv() === $this) {
                $idLangue->setIdCv(null);
            }
        }

        return $this;
    }

    public function getIdBasDePage(): ?BasDePage
    {
        return $this->id_bas_de_page;
    }

    public function setIdBasDePage(?BasDePage $id_bas_de_page): self
    {
        $this->id_bas_de_page = $id_bas_de_page;

        return $this;
    }

    public function getIdTraining(): ?ProfessionalTraining
    {
        return $this->id_training;
    }

    public function setIdTraining(?ProfessionalTraining $id_training): self
    {
        $this->id_training = $id_training;

        return $this;
    }
}