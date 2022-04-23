<?php

namespace App\Entity;

use App\Repository\TrtCandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrtCandidatureRepository::class)]
class TrtCandidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TrtAnnonce::class, inversedBy: 'trtCandidatures')]
    private $annonce;

    #[ORM\ManyToOne(targetEntity: TrtProfilcandidat::class, inversedBy: 'trtCandidatures')]
    private $profil;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnonce(): ?TrtAnnonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?TrtAnnonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getProfil(): ?TrtProfilcandidat
    {
        return $this->profil;
    }

    public function setProfil(?TrtProfilcandidat $profil): self
    {
        $this->profil = $profil;

        return $this;
    }
}
