<?php

namespace App\Entity;

use App\Entity\Traits\DateTimeTrait;
use App\Entity\Traits\EnableTrait;
use App\Repository\ModelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ModelRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Model
{
    use EnableTrait,
        DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

     // Rajouter l'allias(Assert) sur toutes les contraintes
     // NotBlank : Cette propriété ne peut-être null
     // Length : Le client doit respecter la longeur définit dans les contraintes côté applicative
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le contenu ne  doit pas dépasser {{ limit}} caractères,'
    )]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}