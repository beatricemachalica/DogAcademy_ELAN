<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Atelier::class, mappedBy="categorie")
     */
    private $Ateliers;

    public function __construct()
    {
        $this->Ateliers = new ArrayCollection();
    }

    public function getId(): ?int
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

    /**
     * @return Collection|Atelier[]
     */
    public function getAteliers(): Collection
    {
        return $this->Ateliers;
    }

    public function addAtelier(Atelier $atelier): self
    {
        if (!$this->Ateliers->contains($atelier)) {
            $this->Ateliers[] = $atelier;
            $atelier->setCategorie($this);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): self
    {
        if ($this->Ateliers->removeElement($atelier)) {
            // set the owning side to null (unless already changed)
            if ($atelier->getCategorie() === $this) {
                $atelier->setCategorie(null);
            }
        }

        return $this;
    }
}
