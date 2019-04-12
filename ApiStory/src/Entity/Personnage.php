<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnageRepository")
 */
class Personnage
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description_physique;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description_psychologique;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieux", inversedBy="personnages")
     */
    private $origine;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personnage", inversedBy="enfants")
     */
    private $parent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personnage", mappedBy="parent")
     */
    private $enfants;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Livre", inversedBy="personnages")
     */
    private $livre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $principal;

    public function __construct()
    {
        $this->parent = new ArrayCollection();
        $this->enfants = new ArrayCollection();
        $this->livre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDescriptionPhysique(): ?string
    {
        return $this->description_physique;
    }

    public function setDescriptionPhysique(?string $description_physique): self
    {
        $this->description_physique = $description_physique;

        return $this;
    }

    public function getDescriptionPsychologique(): ?string
    {
        return $this->description_psychologique;
    }

    public function setDescriptionPsychologique(?string $description_psychologique): self
    {
        $this->description_psychologique = $description_psychologique;

        return $this;
    }

    public function getOrigine(): ?Lieux
    {
        return $this->origine;
    }

    public function setOrigine(?Lieux $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parent->contains($parent)) {
            $this->parent->removeElement($parent);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getEnfants(): Collection
    {
        return $this->enfants;
    }

    public function addEnfant(self $enfant): self
    {
        if (!$this->enfants->contains($enfant)) {
            $this->enfants[] = $enfant;
            $enfant->addParent($this);
        }

        return $this;
    }

    public function removeEnfant(self $enfant): self
    {
        if ($this->enfants->contains($enfant)) {
            $this->enfants->removeElement($enfant);
            $enfant->removeParent($this);
        }

        return $this;
    }

    /**
     * @return Collection|Livre[]
     */
    public function getLivre(): Collection
    {
        return $this->livre;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livre->contains($livre)) {
            $this->livre[] = $livre;
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livre->contains($livre)) {
            $this->livre->removeElement($livre);
        }

        return $this;
    }

    public function getPrincipal(): ?bool
    {
        return $this->principal;
    }

    public function setPrincipal(?bool $principal): self
    {
        $this->principal = $principal;

        return $this;
    }
}
