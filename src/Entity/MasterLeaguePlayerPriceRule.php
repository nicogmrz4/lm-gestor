<?php

namespace App\Entity;

use App\Repository\MasterLeaguePlayerPriceRuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterLeaguePlayerPriceRuleRepository::class)]
class MasterLeaguePlayerPriceRule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ratingFrom = null;

    #[ORM\Column]
    private ?int $ratingTo = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'playerPriceRules')]
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

    public function getRatingFrom(): ?int
    {
        return $this->ratingFrom;
    }

    public function setRatingFrom(int $ratingFrom): static
    {
        $this->ratingFrom = $ratingFrom;

        return $this;
    }

    public function getRatingTo(): ?int
    {
        return $this->ratingTo;
    }

    public function setRatingTo(int $ratingTo): static
    {
        $this->ratingTo = $ratingTo;

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
