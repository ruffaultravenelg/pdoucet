<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $request_form = null;

    /**
     * @var Collection<int, UserRequest>
     */
    #[ORM\OneToMany(targetEntity: UserRequest::class, mappedBy: 'product')]
    private Collection $userRequests;

    public function __construct()
    {
        $this->userRequests = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function isRequestForm(): ?bool
    {
        return $this->request_form;
    }

    public function setRequestForm(bool $request_form): static
    {
        $this->request_form = $request_form;

        return $this;
    }

    /**
     * @return Collection<int, UserRequest>
     */
    public function getUserRequests(): Collection
    {
        return $this->userRequests;
    }

    public function addUserRequest(UserRequest $userRequest): static
    {
        if (!$this->userRequests->contains($userRequest)) {
            $this->userRequests->add($userRequest);
            $userRequest->setProduct($this);
        }

        return $this;
    }

    public function removeUserRequest(UserRequest $userRequest): static
    {
        if ($this->userRequests->removeElement($userRequest)) {
            // set the owning side to null (unless already changed)
            if ($userRequest->getProduct() === $this) {
                $userRequest->setProduct(null);
            }
        }

        return $this;
    }
}
