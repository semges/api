<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CommissionRepository")
 */
class Commission
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Seminaire", inversedBy="commissions")
     */
    private $seminaire;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contact", mappedBy="commissions")
     */
    private $membres;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->seminaire = new ArrayCollection();
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

    /**
     * @return Collection|Contact[]
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Contact $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
        }

        return $this;
    }

    public function removeMembre(Contact $membre): self
    {
        if ($this->membres->contains($membre)) {
            $this->membres->removeElement($membre);
        }

        return $this;
    }

    /**
     * @return Collection|Seminaire[]
     */
    public function getSeminaire(): Collection
    {
        return $this->seminaire;
    }

    public function addSeminaire(Seminaire $seminaire): self
    {
        if (!$this->seminaire->contains($seminaire)) {
            $this->seminaire[] = $seminaire;
        }

        return $this;
    }

    public function removeSeminaire(Seminaire $seminaire): self
    {
        if ($this->seminaire->contains($seminaire)) {
            $this->seminaire->removeElement($seminaire);
        }

        return $this;
    }
}
