<?php

namespace App\Entity;

use App\Repository\TrtProfessionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrtProfessionsRepository::class)]
class TrtProfessions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $titre;

    #[ORM\OneToMany(mappedBy: 'profession', targetEntity: TrtProfilcandidat::class)]
    private $candidat;

    #[ORM\OneToMany(mappedBy: 'profession', targetEntity: TrtAnnonce::class)]
    private $annonce;

    public function __construct()
    {
        $this->candidat = new ArrayCollection();
        $this->annonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection<int, TrtProfilcandidat>
     */
    public function getCandidat(): Collection
    {
        return $this->candidat;
    }

    public function addCandidat(TrtProfilcandidat $candidat): self
    {
        if (!$this->candidat->contains($candidat)) {
            $this->candidat[] = $candidat;
            $candidat->setProfession($this);
        }

        return $this;
    }

    public function removeCandidat(TrtProfilcandidat $candidat): self
    {
        if ($this->candidat->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getProfession() === $this) {
                $candidat->setProfession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrtAnnonce>
     */
    public function getAnnonce(): Collection
    {
        return $this->annonce;
    }

    public function addAnnonce(TrtAnnonce $annonce): self
    {
        if (!$this->annonce->contains($annonce)) {
            $this->annonce[] = $annonce;
            $annonce->setProfession($this);
        }

        return $this;
    }

    public function removeAnnonce(TrtAnnonce $annonce): self
    {
        if ($this->annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getProfession() === $this) {
                $annonce->setProfession(null);
            }
        }

        return $this;
    }
}
