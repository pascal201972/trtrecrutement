<?php

namespace App\Entity;

use App\Repository\TrtProfilcandidatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrtProfilcandidatRepository::class)]
class TrtProfilcandidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $cv;

    #[ORM\OneToOne(inversedBy: 'TrtProfilcandidat', targetEntity: TrtUser::class, cascade: ['persist', 'remove'])]
    private $idUser;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getIdUser(): ?TrtUser
    {
        return $this->idUser;
    }

    public function setIdUser(?TrtUser $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
