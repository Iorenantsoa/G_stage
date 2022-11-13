<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Stage $stage = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Entreprise $entreprise = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Rapport $rapport = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Presentation $presentation = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?AttestationStage $attestationStage = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?FicheEvaluation $ficheEvaluation = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'enseignant_encadreur')]
    private ?self $user = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: self::class)]
    private Collection $enseignant_encadreur;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Remarques::class)]
    private Collection $remarques;

    #[ORM\Column(nullable: true)]
    private ?int $checkRemarque = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Niveau $niveau = null;

    public function __construct()
    {
        $this->enseignant_encadreur = new ArrayCollection();
        $this->remarques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

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

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): self
    {
        $this->stage = $stage;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getRapport(): ?Rapport
    {
        return $this->rapport;
    }

    public function setRapport(?Rapport $rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }

    public function getPresentation(): ?Presentation
    {
        return $this->presentation;
    }

    public function setPresentation(?Presentation $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getAttestationStage(): ?AttestationStage
    {
        return $this->attestationStage;
    }

    public function setAttestationStage(?AttestationStage $attestationStage): self
    {
        $this->attestationStage = $attestationStage;

        return $this;
    }

    public function getFicheEvaluation(): ?FicheEvaluation
    {
        return $this->ficheEvaluation;
    }

    public function setFicheEvaluation(?FicheEvaluation $ficheEvaluation): self
    {
        $this->ficheEvaluation = $ficheEvaluation;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getUser(): ?self
    {
        return $this->user;
    }

    public function setUser(?self $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getEnseignantEncadreur(): Collection
    {
        return $this->enseignant_encadreur;
    }

    public function addEnseignantEncadreur(self $enseignantEncadreur): self
    {
        if (!$this->enseignant_encadreur->contains($enseignantEncadreur)) {
            $this->enseignant_encadreur->add($enseignantEncadreur);
            $enseignantEncadreur->setUser($this);
        }

        return $this;
    }

    public function removeEnseignantEncadreur(self $enseignantEncadreur): self
    {
        if ($this->enseignant_encadreur->removeElement($enseignantEncadreur)) {
            // set the owning side to null (unless already changed)
            if ($enseignantEncadreur->getUser() === $this) {
                $enseignantEncadreur->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Remarques>
     */
    public function getRemarques(): Collection
    {
        return $this->remarques;
    }

    public function addRemarque(Remarques $remarque): self
    {
        if (!$this->remarques->contains($remarque)) {
            $this->remarques->add($remarque);
            $remarque->setUser($this);
        }

        return $this;
    }

    public function removeRemarque(Remarques $remarque): self
    {
        if ($this->remarques->removeElement($remarque)) {
            // set the owning side to null (unless already changed)
            if ($remarque->getUser() === $this) {
                $remarque->setUser(null);
            }
        }

        return $this;
    }

    public function getCheckRemarque(): ?int
    {
        return $this->checkRemarque;
    }

    public function setCheckRemarque(?int $checkRemarque): self
    {
        $this->checkRemarque = $checkRemarque;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
}
