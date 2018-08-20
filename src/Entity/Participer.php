<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ParticiperRepository")
 */
class Participer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeParticipant", inversedBy="participers")
     */
    private $typeParticipant;

   
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Seminaire", inversedBy="participers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seminaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact", inversedBy="participers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * @ORM\Column(type="boolean")
     */
    private $OnlineRegistered;

   

    public function getId()
    {
        return $this->id;
    }

    public function getConfirmer(): ?bool
    {
        return $this->confirmer;
    }

    public function setConfirmer(bool $confirmer): self
    {
        $this->confirmer = $confirmer;

        return $this;
    }

    public function getTypeParticipant(): ?TypeParticipant
    {
        return $this->typeParticipant;
    }

    public function setTypeParticipant(?TypeParticipant $typeParticipant): self
    {
        $this->typeParticipant = $typeParticipant;

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

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getOnlineRegistered(): ?bool
    {
        return $this->OnlineRegistered;
    }

    public function setOnlineRegistered(bool $OnlineRegistered): self
    {
        $this->OnlineRegistered = $OnlineRegistered;

        return $this;
    }

}
