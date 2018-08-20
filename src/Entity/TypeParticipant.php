<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TypeParticipantRepository")
 */
class TypeParticipant
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
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $montantInscription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participer", mappedBy="typeParticipant")
     */
    private $participers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Seminaire", inversedBy="typeParticipants")
     */
    private $seminaires;

    public function __construct()
    {
        $this->participers = new ArrayCollection();
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

    public function getMontantInscription()
    {
        return $this->montantInscription;
    }

    public function setMontantInscription($montantInscription): self
    {
        $this->montantInscription = $montantInscription;

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
     * @return Collection|Participer[]
     */
    public function getParticipers(): Collection
    {
        return $this->participers;
    }

    public function addParticiper(Participer $participer): self
    {
        if (!$this->participers->contains($participer)) {
            $this->participers[] = $participer;
            $participer->setTypeParticipant($this);
        }

        return $this;
    }

    public function removeParticiper(Participer $participer): self
    {
        if ($this->participers->contains($participer)) {
            $this->participers->removeElement($participer);
            // set the owning side to null (unless already changed)
            if ($participer->getTypeParticipant() === $this) {
                $participer->setTypeParticipant(null);
            }
        }

        return $this;
    }

    public function getSeminaires(): ?Seminaire
    {
        return $this->seminaires;
    }

    public function setSeminaires(?Seminaire $seminaires): self
    {
        $this->seminaires = $seminaires;

        return $this;
    }
}
