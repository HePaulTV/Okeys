<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get; 
use ApiPlatform\Metadata\GetCollection; 
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups; 
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['annonce:list','annonce:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['annonce:list','annonce:item'])]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[Groups(['annonce:list','annonce:item'])]
    private ?Annonce $annonce = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): static
    {
        $this->annonce = $annonce;

        return $this;
    }
}
