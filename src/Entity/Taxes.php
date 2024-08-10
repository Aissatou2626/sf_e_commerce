<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EnableTrait;
use App\Repository\TaxesRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaxesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Taxes
{

    use EnableTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlanK()]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $rate = null;

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

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): static
    {
        $this->rate = $rate;

        return $this;
    }
}
