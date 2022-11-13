<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use App\Traits\TimesTampTraits;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255 , nullable: true)]
    private ?string $first_version = null;

    #[ORM\Column(length: 255 , nullable: true)]
    private ?string $last_version = null;

    #[ORM\OneToOne(mappedBy: 'rapport', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?bool $firstVersionEstDeploye = null;

    #[ORM\Column(nullable: true)]
    private ?bool $lastVersionEstDeploye = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $firstVersionCreatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $firstVersionUpdatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $lastVersionCreatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastVersionUpdatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $firstVersionValidation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $lastVersionValidation = null;

    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstVersion(): ?string
    {
        return $this->first_version;
    }

    public function setFirstVersion(string $first_version): self
    {
        $this->first_version = $first_version;

        return $this;
    }

    public function getLastVersion(): ?string
    {
        return $this->last_version;
    }

    public function setLastVersion(string $last_version): self
    {
        $this->last_version = $last_version;

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
            $this->user->setRapport(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getRapport() !== $this) {
            $user->setRapport($this);
        }

        $this->user = $user;

        return $this;
    }

    public function isFirstVersionEstDeploye(): ?bool
    {
        return $this->firstVersionEstDeploye;
    }

    public function setFirstVersionEstDeploye(?bool $firstVersionEstDeploye): self
    {
        $this->firstVersionEstDeploye = $firstVersionEstDeploye;

        return $this;
    }

    public function isLastVersionEstDeploye(): ?bool
    {
        return $this->lastVersionEstDeploye;
    }

    public function setLastVersionEstDeploye(?bool $lastVersionEstDeploye): self
    {
        $this->lastVersionEstDeploye = $lastVersionEstDeploye;

        return $this;
    }

    public function getFirstVersionCreatedAt(): ?\DateTimeInterface
    {
        return $this->firstVersionCreatedAt;
    }

    public function setFirstVersionCreatedAt(?\DateTimeInterface $firstVersionCreatedAt): self
    {
        $this->firstVersionCreatedAt = $firstVersionCreatedAt;

        return $this;
    }

    public function getFirstVersionUpdatedAt(): ?\DateTimeInterface
    {
        return $this->firstVersionUpdatedAt;
    }

    public function setFirstVersionUpdatedAt(?\DateTimeInterface $firstVersionUpdatedAt): self
    {
        $this->firstVersionUpdatedAt = $firstVersionUpdatedAt;

        return $this;
    }

    public function getLastVersionCreatedAt(): ?\DateTimeInterface
    {
        return $this->lastVersionCreatedAt;
    }

    public function setLastVersionCreatedAt(?\DateTimeInterface $lastVersionCreatedAt): self
    {
        $this->lastVersionCreatedAt = $lastVersionCreatedAt;

        return $this;
    }

    public function getLastVersionUpdatedAt(): ?\DateTimeInterface
    {
        return $this->lastVersionUpdatedAt;
    }

    public function setLastVersionUpdatedAt(?\DateTimeInterface $lastVersionUpdatedAt): self
    {
        $this->lastVersionUpdatedAt = $lastVersionUpdatedAt;

        return $this;
    }

    public function isFirstVersionValidation(): ?bool
    {
        return $this->firstVersionValidation;
    }

    public function setFirstVersionValidation(?bool $firstVersionValidation): self
    {
        $this->firstVersionValidation = $firstVersionValidation;

        return $this;
    }

    public function isLastVersionValidation(): ?bool
    {
        return $this->lastVersionValidation;
    }

    public function setLastVersionValidation(?bool $lastVersionValidation): self
    {
        $this->lastVersionValidation = $lastVersionValidation;

        return $this;
    }

     

}
