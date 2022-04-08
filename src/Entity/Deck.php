<?php

namespace App\Entity;

use App\Repository\DeckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeckRepository::class)]
class Deck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'deck', targetEntity: Card::class, orphanRemoval: true)]
    private $cards;

    #[ORM\OneToOne(mappedBy: 'deck', targetEntity: Cemetery::class, cascade: ['persist', 'remove'])]
    private $cemetery;

    #[ORM\OneToOne(mappedBy: 'deck', targetEntity: Pool::class, cascade: ['persist', 'remove'])]
    private $pool;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setDeck($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getDeck() === $this) {
                $card->setDeck(null);
            }
        }

        return $this;
    }

    public function setCards(Collection $cards): self
    {
        $this->cards = $cards;
        return $this;
    }

    public function getCemetery(): ?Cemetery
    {
        return $this->cemetery;
    }

    public function setCemetery(Cemetery $cemetery): self
    {
        // set the owning side of the relation if necessary
        if ($cemetery->getDeck() !== $this) {
            $cemetery->setDeck($this);
        }

        $this->cemetery = $cemetery;

        return $this;
    }

    public function getPool(): ?Pool
    {
        return $this->pool;
    }

    public function setPool(Pool $pool): self
    {
        // set the owning side of the relation if necessary
        if ($pool->getDeck() !== $this) {
            $pool->setDeck($this);
        }

        $this->pool = $pool;

        return $this;
    }


}
