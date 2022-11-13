<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: StageRepository::class)]
#[ORM\HasLifecycleCallbacks()]


class Stage
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $sujet = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $technologies = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nomEncadreurExt = null;

    #[ORM\Column(length: 70, nullable: true)]
    private ?string $prenomEncadreurExt = null;

    #[ORM\Column(nullable: true)]
    private ?string $validation = null;

    #[ORM\OneToOne(mappedBy: 'stage', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $numeroEncadreurExt = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $adresseEncadreurExt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $aFaitStage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $CreatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $encadre = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(?string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTechnologies(): ?string
    {
        return $this->technologies;
    }

    public function setTechnologies(?string $technologies): self
    {
        $this->technologies = $technologies;

        return $this;
    }

    public function getNomEncadreurExt(): ?string
    {
        return $this->nomEncadreurExt;
    }

    public function setNomEncadreurExt(?string $nomEncadreurExt): self
    {
        $this->nomEncadreurExt = $nomEncadreurExt;

        return $this;
    }

    public function getPrenomEncadreurExt(): ?string
    {
        return $this->prenomEncadreurExt;
    }

    public function setPrenomEncadreurExt(?string $prenomEncadreurExt): self
    {
        $this->prenomEncadreurExt = $prenomEncadreurExt;

        return $this;
    }

    public function getValidation(): ?string
    {
        return $this->validation;
    }

    public function setValidation(?string $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setStage(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getStage() !== $this) {
            $user->setStage($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getNumeroEncadreurExt(): ?string
    {
        return $this->numeroEncadreurExt;
    }

    public function setNumeroEncadreurExt(?string $numeroEncadreurExt): self
    {
        $this->numeroEncadreurExt = $numeroEncadreurExt;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresseEncadreurExt(): ?string
    {
        return $this->adresseEncadreurExt;
    }

    public function setAdresseEncadreurExt(?string $adresseEncadreurExt): self
    {
        $this->adresseEncadreurExt = $adresseEncadreurExt;

        return $this;
    }

    public function isAFaitStage(): ?bool
    {
        return $this->aFaitStage;
    }

    public function setAFaitStage(?bool $aFaitStage): self
    {
        $this->aFaitStage = $aFaitStage;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(?\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    #[ORM\PrePersist()]
    public function onPrePersist(){
        $this->CreatedAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
    #[ORM\PreUpdate()]
    public function onPreUpdate(){
        $this->updatedAt = new \DateTime();
    }

    public function isEncadre(): ?bool
    {
        return $this->encadre;
    }

    public function setEncadre(?bool $encadre): self
    {
        $this->encadre = $encadre;

        return $this;
    }
    

}
