<?php

namespace App\Entity;

use App\Repository\MaitreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaitreRepository::class)
 * @ORM\Table(name="maitre", indexes={@ORM\Index(columns={"nom", "prenom", "mail", "ville"}, flags={"fulltext"})})
 */
class Maitre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=55)
     * @Assert\Length(max=55)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=65)
     * @Assert\Email(message = "Le mail n'est pas valide")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=55)
     * @Assert\Length(max=55)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=55)
     * @Assert\Length(max=55)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=65, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Chien::class, mappedBy="maitre", orphanRemoval=true)
     */
    private $chiens;

    public function __construct()
    {
        $this->chiens = new ArrayCollection();
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Chien[]
     */
    public function getChiens(): Collection
    {
        return $this->chiens;
    }

    public function addChien(Chien $chien): self
    {
        if (!$this->chiens->contains($chien)) {
            $this->chiens[] = $chien;
            $chien->setMaitre($this);
        }

        return $this;
    }

    public function removeChien(Chien $chien): self
    {
        if ($this->chiens->removeElement($chien)) {
            // set the owning side to null (unless already changed)
            if ($chien->getMaitre() === $this) {
                $chien->setMaitre(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom() . ' ' . $this->getPrenom();
    }
}
