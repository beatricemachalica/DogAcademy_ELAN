<?php

namespace App\Entity;

use App\Repository\ChienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChienRepository::class)
 */
class Chien
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Maitre::class, inversedBy="chiens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $maitre;

    /**
     * @ORM\ManyToMany(targetEntity=Session::class, mappedBy="chien")
     */
    private $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
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

    public function getMaitre(): ?Maitre
    {
        return $this->maitre;
    }

    public function setMaitre(?Maitre $maitre): self
    {
        $this->maitre = $maitre;

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->addChien($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            $session->removeChien($this);
        }

        return $this;
    }
}
