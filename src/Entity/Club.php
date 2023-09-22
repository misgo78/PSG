<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
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
    private $nomClub;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseClub;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telClub;

    /**
     * @ORM\OneToMany(targetEntity=Equipe::class, mappedBy="clun")
     */
    private $equipes;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="club")
     */
    private $images;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClub(): ?string
    {
        return $this->nomClub;
    }

    public function setNomClub(string $nomClub): self
    {
        $this->nomClub = $nomClub;

        return $this;
    }

    public function getAdresseClub(): ?string
    {
        return $this->adresseClub;
    }

    public function setAdresseClub(string $adresseClub): self
    {
        $this->adresseClub = $adresseClub;

        return $this;
    }

    public function getTelClub(): ?string
    {
        return $this->telClub;
    }

    public function setTelClub(string $telClub): self
    {
        $this->telClub = $telClub;

        return $this;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
            $equipe->setClun($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getClun() === $this) {
                $equipe->setClun(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setClub($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getClub() === $this) {
                $image->setClub(null);
            }
        }

        return $this;
    }
}
