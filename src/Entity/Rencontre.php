<?php

namespace App\Entity;

use App\Repository\RencontreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RencontreRepository::class)
 */
class Rencontre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRencontre;

    /**
     * @ORM\OneToMany(targetEntity=Equipe::class, mappedBy="rencontre_dom")
     */
    private $equipes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Stade;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domicile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $exterieur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rencontreImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Score;

    /**
     * @ORM\ManyToOne(targetEntity=competition::class)
     */
    private $competition;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRencontre(): ?\DateTimeInterface
    {
        return $this->dateRencontre;
    }

    public function setDateRencontre(\DateTimeInterface $dateRencontre): self
    {
        $this->dateRencontre = $dateRencontre;

        return $this;
    }


    /**
     * @return Collection|Equipe[]
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }



    public function getStade(): ?string
    {
        return $this->Stade;
    }

    public function setStade(string $Stade): self
    {
        $this->Stade = $Stade;

        return $this;
    }

    public function getDomicile(): ?string
    {
        return $this->domicile;
    }

    public function setDomicile(string $domicile): self
    {
        $this->domicile = $domicile;

        return $this;
    }

    public function getExterieur(): ?string
    {
        return $this->exterieur;
    }

    public function setExterieur(string $exterieur): self
    {
        $this->exterieur = $exterieur;

        return $this;
    }

    public function getRencontreImage(): ?string
    {
        return $this->rencontreImage;
    }

    public function setRencontreImage(string $rencontreImage): self
    {
        $this->rencontreImage = $rencontreImage;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->Score;
    }

    public function setScore(?string $Score): self
    {
        $this->Score = $Score;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


}
