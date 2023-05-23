<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $BrochureFilename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrochureFilename(): ?string
    {
        return $this->BrochureFilename;
    }

    public function setBrochureFilename(string $BrochureFilename): self
    {
        $this->BrochureFilename = $BrochureFilename;

        return $this;
    }
}