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
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $isNew = null;

    #[ORM\ManyToOne(inversedBy: 'flowers')]
    private ?Discount $discount = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'flowers')]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'flower', targetEntity: CartFlower::class)]
    private Collection $cartFlowers;

    #[ORM\Column(length: 100)]
    private ?string $image = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isIsNew(): ?bool
    {
        return $this->isNew;
    }

    public function setIsNew(bool $isNew): self
    {
        $this->isNew = $isNew;

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
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
