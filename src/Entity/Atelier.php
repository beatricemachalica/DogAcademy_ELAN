<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AtelierRepository::class)
 */
class Atelier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="Ateliers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Programmer::class, mappedBy="atelier")
     */
    private $programmers;

    public function __construct()
    {
        $this->programmers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Programmer[]
     */
    public function getProgrammers(): Collection
    {
        return $this->programmers;
    }

    public function addProgrammer(Programmer $programmer): self
    {
        if (!$this->programmers->contains($programmer)) {
            $this->programmers[] = $programmer;
            $programmer->setAtelier($this);
        }

        return $this;
    }

    public function removeProgrammer(Programmer $programmer): self
    {
        if ($this->programmers->removeElement($programmer)) {
            // set the owning side to null (unless already changed)
            if ($programmer->getAtelier() === $this) {
                $programmer->setAtelier(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getLibelle();
    }
}
