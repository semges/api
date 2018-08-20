<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
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
    private $nomPrenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "l'adresse mail'{{ value }}' n'est pas valide",
     *     checkMX = true
     * )
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse2;

     /**
     * @ORM\OneToMany(targetEntity="App\Entity\TransactionFin", mappedBy="contact")
     */
    private $transactionFins;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DetailProgram", inversedBy="orateurs")
     */
    private $detailPrograms;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commission", inversedBy="membres")
     */
    private $commissions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participer", mappedBy="contact")
     */
    private $participers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnonymeField", mappedBy="contact")
     */
    private $anonymeFields;

    public function __construct()
    {
        $this->transactionFins = new ArrayCollection();
        $this->detailPrograms = new ArrayCollection();
        $this->commissions = new ArrayCollection();
        $this->participers = new ArrayCollection();
        $this->anonymeFields = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nomPrenom;
    }

    public function setNomPrenom(string $nomPrenom): self
    {
        $this->nomPrenom = $nomPrenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTelephone1(): ?string
    {
        return $this->telephone1;
    }

    public function setTelephone1(?string $telephone1): self
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone2;
    }

    public function setTelephone2(?string $telephone2): self
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(?string $adresse1): self
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

     /**
     * @return Collection|TransactionFin[]
     */
    public function getTransactionFins(): Collection
    {
        return $this->transactionFins;
    }

    public function addTransactionFin(TransactionFin $transactionFin): self
    {
        if (!$this->transactionFins->contains($transactionFin)) {
            $this->transactionFins[] = $transactionFin;
            $transactionFin->setContact($this);
        }

        return $this;
    }

    public function removeTransactionFin(TransactionFin $transactionFin): self
    {
        if ($this->transactionFins->contains($transactionFin)) {
            $this->transactionFins->removeElement($transactionFin);
            // set the owning side to null (unless already changed)
            if ($transactionFin->getContact() === $this) {
                $transactionFin->setContact(null);
            }
        }

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
        }

        return $this;
    }

    public function removeDetailProgram(DetailProgram $detailProgram): self
    {
        if ($this->detailPrograms->contains($detailProgram)) {
            $this->detailPrograms->removeElement($detailProgram);
        }

        return $this;
    }

    /**
     * @return Collection|Commission[]
     */
    public function getCommissions(): Collection
    {
        return $this->commissions;
    }

    public function addCommission(Commission $commission): self
    {
        if (!$this->commissions->contains($commission)) {
            $this->commissions[] = $commission;
        }

        return $this;
    }

    public function removeCommission(Commission $commission): self
    {
        if ($this->commissions->contains($commission)) {
            $this->commissions->removeElement($commission);
        }

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
            $participer->setContact($this);
        }

        return $this;
    }

    public function removeParticiper(Participer $participer): self
    {
        if ($this->participers->contains($participer)) {
            $this->participers->removeElement($participer);
            // set the owning side to null (unless already changed)
            if ($participer->getContact() === $this) {
                $participer->setContact(null);
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
            $anonymeField->setContact($this);
        }

        return $this;
    }

    public function removeAnonymeField(AnonymeField $anonymeField): self
    {
        if ($this->anonymeFields->contains($anonymeField)) {
            $this->anonymeFields->removeElement($anonymeField);
            // set the owning side to null (unless already changed)
            if ($anonymeField->getContact() === $this) {
                $anonymeField->setContact(null);
            }
        }

        return $this;
    }
}
