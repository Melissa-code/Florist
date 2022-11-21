<?php

namespace App\Entity;

use App\Repository\FlowerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlowerRepository::class)]
class Flower
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $new = null;

    #[ORM\ManyToOne(inversedBy: 'flowers')]
    private ?Discount $discount = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'flowers')]
    private Collection $category;

    #[ORM\OneToMany(mappedBy: 'flower', targetEntity: CartFlower::class)]
    private Collection $cartFlowers;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->cartFlowers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function isNew(): ?bool
    {
        return $this->new;
    }

    public function setNew(bool $new): self
    {
        $this->new = $new;

        return $this;
    }

    public function getDiscount(): ?Discount
    {
        return $this->discount;
    }

    public function setDiscount(?Discount $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, CartFlower>
     */
    public function getCartFlowers(): Collection
    {
        return $this->cartFlowers;
    }

    public function addCartFlower(CartFlower $cartFlower): self
    {
        if (!$this->cartFlowers->contains($cartFlower)) {
            $this->cartFlowers->add($cartFlower);
            $cartFlower->setFlower($this);
        }

        return $this;
    }

    public function removeCartFlower(CartFlower $cartFlower): self
    {
        if ($this->cartFlowers->removeElement($cartFlower)) {
            // set the owning side to null (unless already changed)
            if ($cartFlower->getFlower() === $this) {
                $cartFlower->setFlower(null);
            }
        }

        return $this;
    }
}