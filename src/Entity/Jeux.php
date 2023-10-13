<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuxRepository::class)]
class Jeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomJeux = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $realisedAt = null;

    #[ORM\Column(nullable: true)]
    private ?float $noteMoyenne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgCouverture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomJeux(): ?string
    {
        return $this->nomJeux;
    }

    public function setNomJeux(?string $nomJeux): static
    {
        $this->nomJeux = $nomJeux;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getRealisedAt(): ?\DateTimeInterface
    {
        return $this->realisedAt;
    }

    public function setRealisedAt(?\DateTimeInterface $realisedAt): static
    {
        $this->realisedAt = $realisedAt;

        return $this;
    }

    public function getNoteMoyenne(): ?float
    {
        return $this->noteMoyenne;
    }

    public function setNoteMoyenne(?float $noteMoyenne): static
    {
        $this->noteMoyenne = $noteMoyenne;

        return $this;
    }

    public function getImgCouverture(): ?string
    {
        return $this->imgCouverture;
    }

    public function setImgCouverture(?string $imgCouverture): static
    {
        $this->imgCouverture = $imgCouverture;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
