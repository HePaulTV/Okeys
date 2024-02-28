<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get; 
use ApiPlatform\Metadata\GetCollection; 

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups; 

#[ApiResource(operations:[new Get(normalizationContext:['groups'=>'annonce:item']),
                          new GetCollection(normalizationContext:['groups'=>'annonce:list'])])]

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['annonce:list','annonce:item'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    #[Groups(['annonce:list','annonce:item'])]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(['annonce:list','annonce:item'])]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['annonce:list','annonce:item'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['annonce:list','annonce:item'])]
    private ?float $prix = null;

    #[ORM\Column]
    #[Groups(['annonce:list','annonce:item'])]
    private ?float $m2 = null;

    #[ORM\Column]
    #[Groups(['annonce:list','annonce:item'])]
    private ?bool $jardin = null;

    #[ORM\Column]
    #[Groups(['annonce:list','annonce:item'])]
    private ?bool $garage = null;

    #[ORM\Column(length: 255)]
    #[Groups(['annonce:list','annonce:item'])]
    private ?string $commune = null;

    #[ORM\Column(length: 255)]
    #[Groups(['annonce:list','annonce:item'])]
    private ?string $region = null;

    #[ORM\Column(length: 255)]
    #[Groups(['annonce:list','annonce:item'])]
    private ?string $departement = null;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Type::class)]
    //#[Groups(['annonce:list','annonce:item'])]
    private Collection $types;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    private ?Type $type = null;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Visite::class)]
    #[Groups(['annonce:list','annonce:item'])]
    private Collection $visites;

    public function __construct()
    {
        $this->types = new ArrayCollection();
        $this->visites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getM2(): ?float
    {
        return $this->m2;
    }

    public function setM2(float $m2): static
    {
        $this->m2 = $m2;

        return $this;
    }

    public function isJardin(): ?bool
    {
        return $this->jardin;
    }

    public function setJardin(bool $jardin): static
    {
        $this->jardin = $jardin;

        return $this;
    }

    public function isGarage(): ?bool
    {
        return $this->garage;
    }

    public function setGarage(bool $garage): static
    {
        $this->garage = $garage;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): static
    {
        $this->commune = $commune;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->setAnnonce($this);
        }

        return $this;
    }

    public function removeType(Type $type): static
    {
        if ($this->types->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getAnnonce() === $this) {
                $type->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Visite>
     */
    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(Visite $visite): static
    {
        if (!$this->visites->contains($visite)) {
            $this->visites->add($visite);
            $visite->setAnnonce($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getAnnonce() === $this) {
                $visite->setAnnonce(null);
            }
        }

        return $this;
    }
}
