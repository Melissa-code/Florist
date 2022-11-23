<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\OneToOne(inversedBy: 'cart', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'cart', cascade: ['persist', 'remove'])]
    private ?Invoice $invoice = null;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartFlower::class)]
    private Collection $cartFlowers;

    public function __construct()
    {
        $this->cartFlowers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): self
    {
        // set the owning side of the relation if necessary
        if ($invoice->getCart() !== $this) {
            $invoice->setCart($this);
        }

        $this->invoice = $invoice;

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
            $cartFlower->setCart($this);
        }

        return $this;
    }

    public function removeCartFlower(CartFlower $cartFlower): self
    {
        if ($this->cartFlowers->removeElement($cartFlower)) {
            // set the owning side to null (unless already changed)
            if ($cartFlower->getCart() === $this) {
                $cartFlower->setCart(null);
            }
        }

        return $this;
    }
}
