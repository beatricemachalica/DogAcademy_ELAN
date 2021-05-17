<?php

namespace App\Entity;

use App\Repository\ChienRepository;
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
}
