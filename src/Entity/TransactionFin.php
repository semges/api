<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionFinRepository")
 */
class TransactionFin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTransaction;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motif;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sens;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rubrique", inversedBy="transactionFins")
     */
    private $rubrique;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Seminaire", inversedBy="transactionFins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seminaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact", inversedBy="transactionFins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * @ORM\Column(type="smallint")
     */
    private $payementForm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $refNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autherPayMethodName;

  

    public function getId()
    {
        return $this->id;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->dateTransaction;
    }

    public function setDateTransaction(\DateTimeInterface $dateTransaction): self
    {
        $this->dateTransaction = $dateTransaction;

        return $this;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setMontant($montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

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

    public function getSens(): ?int
    {
        return $this->sens;
    }

    public function setSens(int $sens): self
    {
        $this->sens = $sens;

        return $this;
    }

    public function getRubrique(): ?Rubrique
    {
        return $this->rubrique;
    }

    public function setRubrique(?Rubrique $rubrique): self
    {
        $this->rubrique = $rubrique;

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

    public function getPayementForm(): ?int
    {
        return $this->payementForm;
    }

    public function setPayementForm(int $payementForm): self
    {
        $this->payementForm = $payementForm;

        return $this;
    }

    public function getRefNumber(): ?string
    {
        return $this->refNumber;
    }

    public function setRefNumber(?string $refNumber): self
    {
        $this->refNumber = $refNumber;

        return $this;
    }

    public function getAutherPayMethodName(): ?string
    {
        return $this->autherPayMethodName;
    }

    public function setAutherPayMethodName(?string $autherPayMethodName): self
    {
        $this->autherPayMethodName = $autherPayMethodName;

        return $this;
    }
}
