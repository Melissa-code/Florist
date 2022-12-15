<?php

namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DiscountRepository::class)]
class Discount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Range(notInRangeMessage: 'La promotion doit être comprise entre {{ min }} et {{ max }}', min: 0.1, max: 0.9,)]
    #[Assert\NotNull]
    private ?float $value = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    //#[Assert\Date]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    //#[Assert\Date]
    private ?\DateTimeInterface $end = null;

    #[ORM\OneToMany(mappedBy: 'discount', targetEntity: Flower::class)]
    private Collection $flowers;

    public function __construct()
    {
        $this->flowers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return Collection<int, Flower>
     */
    public function getFlowers(): Collection
    {
        return $this->flowers;
    }

    public function addFlower(Flower $flower): self
    {
        if (!$this->flowers->contains($flower)) {
            $this->flowers->add($flower);
            $flower->setDiscount($this);
        }

        return $this;
    }

    public function removeFlower(Flower $flower): self
    {
        if ($this->flowers->removeElement($flower)) {
            // set the owning side to null (unless already changed)
            if ($flower->getDiscount() === $this) {
                $flower->setDiscount(null);
            }
        }

        return $this;
    }
}
