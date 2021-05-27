<?php

namespace App\Entity;


use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlace;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="Sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formation;

    /**
     * @ORM\ManyToMany(targetEntity=Chien::class, inversedBy="sessions")
     */
    private $chien;

    /**
     * @ORM\OneToMany(targetEntity=Programmer::class, mappedBy="session", cascade={"persist"})
     */
    private $programmers;

    public function __construct()
    {
        $this->chien = new ArrayCollection();
        $this->programmers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

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

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection|Chien[]
     */
    public function getChien(): Collection
    {
        return $this->chien;
    }

    public function addChien(Chien $chien): self
    {
        if (!$this->chien->contains($chien)) {
            $this->chien[] = $chien;
        }

        return $this;
    }

    public function removeChien(Chien $chien): self
    {
        $this->chien->removeElement($chien);

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
            $programmer->setSession($this);
        }

        return $this;
    }

    public function removeProgrammer(Programmer $programmer): self
    {
        if ($this->programmers->removeElement($programmer)) {
            // set the owning side to null (unless already changed)
            if ($programmer->getSession() === $this) {
                $programmer->setSession(null);
            }
        }

        return $this;
    }
}
