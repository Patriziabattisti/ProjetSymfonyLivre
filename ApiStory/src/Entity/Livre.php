<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LivreRepository")
 */
class Livre
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $resume;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couverture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="livres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chapitre", mappedBy="livre", orphanRemoval=true, cascade={"persist"})
     */
    private $chapitres;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Monde", mappedBy="livre")
     */
    private $mondes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personnage", mappedBy="livre")
     * @ORM\JoinTable(name="personnage_livre")
     */
    private $personnages;

    public function __construct()
    {
        $this->chapitres = new ArrayCollection();
        $this->mondes = new ArrayCollection();
        $this->personnages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getCouverture() 
    {
        return $this->couverture;
    }

    public function setCouverture($couverture) 
    {
        $this->couverture = $couverture;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Chapitre[]
     */
    public function getChapitres(): Collection
    {
        return $this->chapitres;
    }

    public function addChapitre(Chapitre $chapitre): self
    {
        if (!$this->chapitres->contains($chapitre)) {
            $this->chapitres[] = $chapitre;
            $chapitre->setLivre($this);
        }

        return $this;
    }

    public function removeChapitre(Chapitre $chapitre): self
    {
        if ($this->chapitres->contains($chapitre)) {
            $this->chapitres->removeElement($chapitre);
            // set the owning side to null (unless already changed)
            if ($chapitre->getLivre() === $this) {
                $chapitre->setLivre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Monde[]
     */
    public function getMondes(): Collection
    {
        return $this->mondes;
    }

    public function addMonde(Monde $monde): self
    {
        if (!$this->mondes->contains($monde)) {
            $this->mondes[] = $monde;
            $monde->addLivre($this);
        }

        return $this;
    }

    public function removeMonde(Monde $monde): self
    {
        if ($this->mondes->contains($monde)) {
            $this->mondes->removeElement($monde);
            $monde->removeLivre($this);
        }

        return $this;
    }

    /**
     * @return Collection|Personnage[]
     */
    public function getPersonnages(): Collection
    {
        return $this->personnages;
    }

    public function addPersonnage(Personnage $personnage): self
    {
        if (!$this->personnages->contains($personnage)) {
            $this->personnages[] = $personnage;
            $personnage->addLivre($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->personnages->contains($personnage)) {
            $this->personnages->removeElement($personnage);
            $personnage->removeLivre($this);
        }

        return $this;
    }
}
