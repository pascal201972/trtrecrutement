<?php

namespace App\Entity;

use App\Repository\TrtAnnonceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrtAnnonceRepository::class)]
class TrtAnnonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'text')]
    private $mission;

    #[ORM\Column(type: 'text')]
    private $vous;

    #[ORM\Column(type: 'string', length: 100)]
    private $ville;

    #[ORM\Column(type: 'string', length: 10)]
    private $contrat;

    #[ORM\Column(type: 'string', length: 10)]
    private $horaire;

    #[ORM\Column(type: 'integer')]
    private $salaireAnnuel;

    #[ORM\Column(type: 'boolean')]
    private $valider;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(string $mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    public function getVous(): ?string
    {
        return $this->vous;
    }

    public function setVous(string $vous): self
    {
        $this->vous = $vous;

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

    public function getContrat(): ?string
    {
        return $this->contrat;
    }

    public function setContrat(string $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getSalaireAnnuel(): ?int
    {
        return $this->salaireAnnuel;
    }

    public function setSalaireAnnuel(int $salaireAnnuel): self
    {
        $this->salaireAnnuel = $salaireAnnuel;

        return $this;
    }

    public function getValider(): ?bool
    {
        return $this->valider;
    }

    public function setValider(bool $valider): self
    {
        $this->valider = $valider;

        return $this;
    }
}
