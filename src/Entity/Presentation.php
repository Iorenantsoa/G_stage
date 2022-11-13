<?php

namespace App\Entity;

use App\Repository\PresentationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresentationRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Presentation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $fichier = null;

    #[ORM\OneToOne(mappedBy: 'presentation', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?bool $estDeploye = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $presentationValidation = null;

    

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

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
            $this->user->setPresentation(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPresentation() !== $this) {
            $user->setPresentation($this);
        }

        $this->user = $user;

        return $this;
    }

    public function isEstDeploye(): ?bool
    {
        return $this->estDeploye;
    }

    public function setEstDeploye(?bool $estDeploye): self
    {
        $this->estDeploye = $estDeploye;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
    
    public function isPresentationValidation(): ?bool
    {
        return $this->presentationValidation;
    }

    public function setPresentationValidation(?bool $presentationValidation): self
    {
        $this->presentationValidation = $presentationValidation;

        return $this;
    }
    #[ORM\PrePersist()]
    public function onPrePersist(){
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
    #[ORM\PreUpdate()]
    public function onPreUpdate(){
        $this->updatedAt = new \DateTime();
    }
    
}
