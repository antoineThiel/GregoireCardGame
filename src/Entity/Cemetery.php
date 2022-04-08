<?php

namespace App\Entity;

use App\Repository\CemeteryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CemeteryRepository::class)]
class Cemetery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'cemetery', targetEntity: Card::class)]
    private $cards;

    #[ORM\OneToOne(inversedBy: 'cemetery', targetEntity: Deck::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $deck;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function getCardsInCemetery(): Collection
    {
        $cards = new ArrayCollection();
        foreach ($this->cards as $card)
        {
            if ($card->getInCemetery())
            {
                $cards->add($card);
            }
        }
        return $cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setCemetery($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getCemetery() === $this) {
                $card->setCemetery(null);
            }
        }

        return $this;
    }

    public function getDeck(): ?Deck
    {
        return $this->deck;
    }

    public function setDeck(Deck $deck): self
    {
        $this->deck = $deck;

        return $this;
    }
}
