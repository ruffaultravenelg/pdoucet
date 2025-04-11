<?php

namespace App\Entity;

use App\Repository\DepecheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepecheRepository::class)]
class Depeche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 2040)]
    private ?string $text = null;

    #[ORM\Column]
    private ?bool $is_positive = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function isPositive(): ?bool
    {
        return $this->is_positive;
    }

    public function setIsPositive(bool $is_positive): static
    {
        $this->is_positive = $is_positive;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }
}
