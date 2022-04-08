<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $text;

    #[ORM\ManyToOne(targetEntity: Deck::class, inversedBy: 'cards')]
    #[ORM\JoinColumn(nullable: false)]
    private $deck;

    #[ORM\ManyToOne(targetEntity: Pool::class, inversedBy: 'cards')]
    private $pool;

    #[ORM\ManyToOne(targetEntity: Cemetery::class, inversedBy: 'cards')]
    private $cemetery;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $inPool;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $inCemetery;

    public function __construct()
    {
        //$this->decks = new ArrayCollection();
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getDeck(): ?Deck
    {
        return $this->deck;
    }

    public function setDeck(?Deck $deck): self
    {
        $this->deck = $deck;

        return $this;
    }

    public function getPool(): ?Pool
    {
        return $this->pool;
    }

    public function setPool(?Pool $pool): self
    {
        $this->pool = $pool;

        return $this;
    }

    public function getCemetery(): ?Cemetery
    {
        return $this->cemetery;
    }

    public function setCemetery(?Cemetery $cemetery): self
    {
        $this->cemetery = $cemetery;

        return $this;
    }

    public function getInPool(): ?bool
    {
        return $this->inPool;
    }

    public function setInPool(?bool $inPool): self
    {
        $this->inPool = $inPool;

        return $this;
    }

    public function getInCemetery(): ?bool
    {
        return $this->inCemetery;
    }

    public function setInCemetery(?bool $inCemetery): self
    {
        $this->inCemetery = $inCemetery;

        return $this;
    }


}
