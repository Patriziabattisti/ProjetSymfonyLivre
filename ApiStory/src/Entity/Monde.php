<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MondeRepository")
 */
class Monde
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Livre", inversedBy="mondes")
     */
    private $livre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lieux", mappedBy="monde")
     */
    private $leslieux;

    public function __construct()
    {
        $this->livre = new ArrayCollection();
        $this->leslieux = new ArrayCollection();
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

    /**
     * @return Collection|Lieux[]
     */
    public function getLeslieux(): Collection
    {
        return $this->leslieux;
    }

    public function addLeslieux(Lieux $leslieux): self
    {
        if (!$this->leslieux->contains($leslieux)) {
            $this->leslieux[] = $leslieux;
            $leslieux->setMonde($this);
        }

        return $this;
    }

    public function removeLeslieux(Lieux $leslieux): self
    {
        if ($this->leslieux->contains($leslieux)) {
            $this->leslieux->removeElement($leslieux);
            // set the owning side to null (unless already changed)
            if ($leslieux->getMonde() === $this) {
                $leslieux->setMonde(null);
            }
        }

        return $this;
    }
}
