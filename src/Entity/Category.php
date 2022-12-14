<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min: 3, max: 50, minMessage: 'Le nom doit comporter au minimum {{ limit }} caractères', maxMessage: 'Le nom doit comporter au maximum {{ limit }} caractères',)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Flower::class, mappedBy: 'categories')]
    private Collection $flowers;

    public function __construct()
    {
        $this->flowers = new ArrayCollection();
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
            $flower->addCategory($this);
        }

        return $this;
    }

    public function removeFlower(Flower $flower): self
    {
        if ($this->flowers->removeElement($flower)) {
            $flower->removeCategory($this);
        }

        return $this;
    }
}
