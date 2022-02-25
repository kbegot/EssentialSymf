<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfesseurRepository::class)
 */
class Professeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity=matiere::class, mappedBy="professeur")
     */
    private $matiere;

    /**
     * @ORM\OneToOne(targetEntity=user::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Classe::class, mappedBy="Professeur")
     */
    private $classes;

    public function __construct()
    {
        $this->matiere = new ArrayCollection();
        $this->classes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, matiere>
     */
    public function getMatiere(): Collection
    {
        return $this->matiere;
    }

    public function addMatiere(matiere $matiere): self
    {
        if (!$this->matiere->contains($matiere)) {
            $this->matiere[] = $matiere;
            $matiere->setProfesseur($this);
        }

        return $this;
    }

    public function removeMatiere(matiere $matiere): self
    {
        if ($this->matiere->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getProfesseur() === $this) {
                $matiere->setProfesseur(null);
            }
        }

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->addProfesseur($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        if ($this->classes->removeElement($class)) {
            $class->removeProfesseur($this);
        }

        return $this;
    }
}
