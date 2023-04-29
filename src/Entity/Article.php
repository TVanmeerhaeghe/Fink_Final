<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[UniqueEntity('titre')]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2,max:100)]
    private ?string $titre = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2,max:100)]
    private ?string $sujet = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $contenu = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->date = new \DateTimeImmutable;
    }

    #[ORM\PrePersist]
    public function setDateValue()
    {
        $this->date = new \DateTimeImmutable;
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

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

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
