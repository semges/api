<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammeRepository")
 */
class Programme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Seminaire", inversedBy="programmes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seminaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DetailProgram", mappedBy="programme")
     */
    private $detailPrograms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnonymeField", mappedBy="programme")
     */
    private $anonymeFields;

    public function __construct()
    {
        $this->detailPrograms = new ArrayCollection();
        $this->anonymeFields = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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

    public function getAnonyme1(): ?string
    {
        return $this->anonyme1;
    }

    public function setAnonyme1(?string $anonyme1): self
    {
        $this->anonyme1 = $anonyme1;

        return $this;
    }

    public function getAnonyme2(): ?string
    {
        return $this->anonyme2;
    }

    public function setAnonyme2(?string $anonyme2): self
    {
        $this->anonyme2 = $anonyme2;

        return $this;
    }

    public function getAnonyme3(): ?string
    {
        return $this->anonyme3;
    }

    public function setAnonyme3(?string $anonyme3): self
    {
        $this->anonyme3 = $anonyme3;

        return $this;
    }

    public function getAnonyme4(): ?string
    {
        return $this->anonyme4;
    }

    public function setAnonyme4(?string $anonyme4): self
    {
        $this->anonyme4 = $anonyme4;

        return $this;
    }

    public function getAnonyme5(): ?string
    {
        return $this->anonyme5;
    }

    public function setAnonyme5(?string $anonyme5): self
    {
        $this->anonyme5 = $anonyme5;

        return $this;
    }

    public function getSeminaire(): ?Seminaire
    {
        return $this->seminaire;
    }

    public function setSeminaire(?Seminaire $seminaire): self
    {
        $this->seminaire = $seminaire;

        return $this;
    }

    /**
     * @return Collection|DetailProgram[]
     */
    public function getDetailPrograms(): Collection
    {
        return $this->detailPrograms;
    }

    public function addDetailProgram(DetailProgram $detailProgram): self
    {
        if (!$this->detailPrograms->contains($detailProgram)) {
            $this->detailPrograms[] = $detailProgram;
            $detailProgram->setProgramme($this);
        }

        return $this;
    }

    public function removeDetailProgram(DetailProgram $detailProgram): self
    {
        if ($this->detailPrograms->contains($detailProgram)) {
            $this->detailPrograms->removeElement($detailProgram);
            // set the owning side to null (unless already changed)
            if ($detailProgram->getProgramme() === $this) {
                $detailProgram->setProgramme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AnonymeField[]
     */
    public function getAnonymeFields(): Collection
    {
        return $this->anonymeFields;
    }

    public function addAnonymeField(AnonymeField $anonymeField): self
    {
        if (!$this->anonymeFields->contains($anonymeField)) {
            $this->anonymeFields[] = $anonymeField;
            $anonymeField->setProgramme($this);
        }

        return $this;
    }

    public function removeAnonymeField(AnonymeField $anonymeField): self
    {
        if ($this->anonymeFields->contains($anonymeField)) {
            $this->anonymeFields->removeElement($anonymeField);
            // set the owning side to null (unless already changed)
            if ($anonymeField->getProgramme() === $this) {
                $anonymeField->setProgramme(null);
            }
        }

        return $this;
    }
}
