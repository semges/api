<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\SeminaireRepository")
 */
class Seminaire
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
     * @ORM\Column(type="datetime")
     */
    private $annee;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $referenceCle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $citationCle;

      
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rubrique", mappedBy="seminaire")
     */
    private $rubriques;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commission", mappedBy="seminaire")
     */
    private $commissions;

   
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participer", mappedBy="seminaire")
     */
    private $participers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnonymeField", mappedBy="seminaire")
     */
    private $anonymeFields;

 
   
    public function __construct()
    {
        $this->rubriques = new ArrayCollection();
        $this->commissions = new ArrayCollection();
        $this->participers = new ArrayCollection();
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

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getReferenceCle(): ?string
    {
        return $this->referenceCle;
    }

    public function setReferenceCle(?string $referenceCle): self
    {
        $this->referenceCle = $referenceCle;

        return $this;
    }

    public function getCitationCle(): ?string
    {
        return $this->citationCle;
    }

    public function setCitationCle(?string $citationCle): self
    {
        $this->citationCle = $citationCle;

        return $this;
    }

    /**
     * @return Collection|Rubrique[]
     */
    public function getRubriques(): Collection
    {
        return $this->rubriques;
    }

    public function addRubrique(Rubrique $rubrique): self
    {
        if (!$this->rubriques->contains($rubrique)) {
            $this->rubriques[] = $rubrique;
            $rubrique->setSeminaire($this);
        }

        return $this;
    }

    public function removeRubrique(Rubrique $rubrique): self
    {
        if ($this->rubriques->contains($rubrique)) {
            $this->rubriques->removeElement($rubrique);
            // set the owning side to null (unless already changed)
            if ($rubrique->getSeminaire() === $this) {
                $rubrique->setSeminaire(null);
            }
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
            $commission->addSeminaire($this);
        }

        return $this;
    }

    public function removeCommission(Commission $commission): self
    {
        if ($this->commissions->contains($commission)) {
            $this->commissions->removeElement($commission);
            $commission->removeSeminaire($this);
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
            $participer->setSeminaire($this);
        }

        return $this;
    }

    public function removeParticiper(Participer $participer): self
    {
        if ($this->participers->contains($participer)) {
            $this->participers->removeElement($participer);
            // set the owning side to null (unless already changed)
            if ($participer->getSeminaire() === $this) {
                $participer->setSeminaire(null);
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
            $anonymeField->setSeminaire($this);
        }

        return $this;
    }

    public function removeAnonymeField(AnonymeField $anonymeField): self
    {
        if ($this->anonymeFields->contains($anonymeField)) {
            $this->anonymeFields->removeElement($anonymeField);
            // set the owning side to null (unless already changed)
            if ($anonymeField->getSeminaire() === $this) {
                $anonymeField->setSeminaire(null);
            }
        }

        return $this;
    }

    
    
}
