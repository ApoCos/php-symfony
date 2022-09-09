<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:'Veuillez saisir un titre')]
    #[Assert\Length(min: 5, max: 30)]
    private ?string $titre = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:'Veuillez saisir un prix')]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Categorie $relation = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Categorie::class)]
    #[Assert\NotBlank(
        message: "Veuillez sélectionner une catégorie"
    )]
    private Collection $categorie;

    #[ORM\ManyToMany(targetEntity: Matiere::class, inversedBy: 'produits')]
    #[Assert\Count(
        min: 1,
        minMessage: "Veuillez cocher une matière"
    )]
    private Collection $matieres;

    public function __construct()
    {
        $this->categorie = new ArrayCollection();
        $this->matieres = new ArrayCollection();
    }

    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

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

    // public function getImage(): ?string
    // {
    //     return $this->image;
    // }

    // public function setImage(?string $image): self
    // {
    //     $this->image = $image;

    //     return $this;
    // }

    public function getRelation(): ?Categorie
    {
        return $this->relation;
    }

    public function setRelation(?Categorie $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie->add($categorie);
            $categorie->setProduit($this);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        if ($this->categorie->removeElement($categorie)) {
            // set the owning side to null (unless already changed)
            if ($categorie->getProduit() === $this) {
                $categorie->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        $this->matieres->removeElement($matiere);

        return $this;
    }
}
