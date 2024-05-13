<?php

namespace App\Entity;

use App\Repository\MasterLeaguePlayerCardRuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterLeaguePlayerCardRuleRepository::class)]
class MasterLeaguePlayerCardRule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cardType = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?bool $onceTime = null;

    #[ORM\ManyToOne(inversedBy: 'playerCardRules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MasterLeague $masterLeague = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable;
        $this->updatedAt = new \DateTimeImmutable;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardType(): ?string
    {
        return $this->cardType;
    }

    public function setCardType(string $cardType): static
    {
        $this->cardType = $cardType;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isOnceTime(): ?bool
    {
        return $this->onceTime;
    }

    public function setOnceTime(bool $onceTime): static
    {
        $this->onceTime = $onceTime;

        return $this;
    }

    public function getMasterLeague(): ?MasterLeague
    {
        return $this->masterLeague;
    }

    public function setMasterLeague(?MasterLeague $masterLeague): static
    {
        $this->masterLeague = $masterLeague;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
