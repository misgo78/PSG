<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="equipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Personne::class, mappedBy="equipe")
     */
    private $personne;


    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="equipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clun;

    public function __construct()
    {
        $this->personne = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Personne[]
     */
    public function getPersonne(): Collection
    {
        return $this->personne;
    }

    public function addPersonne(Personne $personne): self
    {
        if (!$this->personne->contains($personne)) {
            $this->personne[] = $personne;
            $personne->setEquipe($this);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): self
    {
        if ($this->personne->removeElement($personne)) {
            // set the owning side to null (unless already changed)
            if ($personne->getEquipe() === $this) {
                $personne->setEquipe(null);
            }
        }

        return $this;
    }

    public function getClun(): ?Club
    {
        return $this->clun;
    }

    public function setClun(?Club $clun): self
    {
        $this->clun = $clun;

        return $this;
    }
}
