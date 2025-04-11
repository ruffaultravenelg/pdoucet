<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
class Content
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', length: 100)]
    private string $key;

    #[ORM\Column(length: 2040)]
    private ?string $content = null;

    public function __construct(string $key, string $content)
    {
        $this->key = $key;
        $this->content = $content;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
