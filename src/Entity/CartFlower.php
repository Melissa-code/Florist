<?php

namespace App\Entity;

use App\Repository\CartFlowerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartFlowerRepository::class)]
class CartFlower
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cartFlowers')]
    private ?Flower $flower = null;

    #[ORM\ManyToOne(inversedBy: 'cartFlowers')]
    private ?Cart $cart = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlower(): ?Flower
    {
        return $this->flower;
    }

    public function setFlower(?Flower $flower): self
    {
        $this->flower = $flower;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
