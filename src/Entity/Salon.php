<?php

namespace App\Entity;

use App\Repository\SalonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: SalonRepository::class)]
#[UniqueEntity('Email')]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Salon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2,max:50)]
    private ?string $Nom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $Adresse = null;

    #[ORM\Column]
    private ?int $Telephone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2,max:100)]
    private ?string $Ville = null;

    #[ORM\ManyToOne(inversedBy: 'salons')]
    #[Assert\NotBlank()]
    private ?User $Proprietaire = null;

    #[ORM\Column(length: 180)]
    #[Assert\Email()]
    #[Assert\Length(min:2,max:180)]
    private ?string $Email = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 8, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 8, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    private ?string $Style = null;

    #[Vich\UploadableField(mapping: 'salon_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $Siret = null;

    #[ORM\Column]
    private ?bool $isTrusted = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'Salon', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->updatedAt = new \DateTimeImmutable;
    }
    
    #[ORM\PrePersist]
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTimeImmutable;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->Telephone;
    }

    public function setTelephone(int $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getProprietaire(): ?User
    {
        return $this->Proprietaire;
    }

    public function setProprietaire(?User $Proprietaire): self
    {
        $this->Proprietaire = $Proprietaire;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->Style;
    }

    public function setStyle(string $Style): self
    {
        $this->Style = $Style;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getSiret(): ?int
    {
        return $this->Siret;
    }

    public function setSiret(int $Siret): self
    {
        $this->Siret = $Siret;

        return $this;
    }

    public function isIsTrusted(): ?bool
    {
        return $this->isTrusted;
    }

    public function setIsTrusted(bool $isTrusted): self
    {
        $this->isTrusted = $isTrusted;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setSalon($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getSalon() === $this) {
                $reservation->setSalon(null);
            }
        }

        return $this;
    }

}
