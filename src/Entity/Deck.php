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

    #[ORM\ManyToMany(targetEntity: Card::class, inversedBy: 'decks')]
    private $card;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private $cemetery;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private $pool;

    #[ORM\Column(type: 'boolean')]
    private $isCemetery;

    #[ORM\Column(type: 'boolean')]
    private $isPool;

    public function __construct()
    {
        $this->card = new ArrayCollection();
        $this->isPool = false;
        $this->isCemetery = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCards(Collection $cards): void
    {
        $this->card = $cards;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCard(): Collection
    {
        return $this->card;
    }

    public function addCard(Card $card): self
    {
        if (!$this->card->contains($card)) {
            $this->card[] = $card;
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        $this->card->removeElement($card);

        return $this;
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

    public function getCemetery(): ?self
    {
        return $this->cemetery;
    }

    public function setCemetery(?self $cemetery): self
    {
        $this->cemetery = $cemetery;

        return $this;
    }

    public function getPool(): ?self
    {
        return $this->pool;
    }

    public function setPool(?self $pool): self
    {
        $this->pool = $pool;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsCemetery()
    {
        return $this->isCemetery;
    }

    /**
     * @param mixed $isCemetery
     */
    public function setIsCemetery($isCemetery): void
    {
        $this->isCemetery = $isCemetery;
    }

    /**
     * @return mixed
     */
    public function getIsPool()
    {
        return $this->isPool;
    }

    /**
     * @param mixed $isPool
     */
    public function setIsPool($isPool): void
    {
        $this->isPool = $isPool;
    }





}
