<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $inGameId = null;

    #[ORM\Column]
    private ?bool $isTransferable = null;

    #[ORM\Column]
    private ?bool $isLoanable = null;

    #[ORM\Column]
    private ?int $salary = null;

    #[ORM\Column]
    private ?bool $inLoan = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    #[ORM\ManyToOne]
    private ?Team $ownerTeam = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getInGameId(): ?string
    {
        return $this->inGameId;
    }

    public function setInGameId(string $inGameId): static
    {
        $this->inGameId = $inGameId;

        return $this;
    }

    public function isTransferable(): ?bool
    {
        return $this->isTransferable;
    }

    public function setTransferable(bool $isTransferable): static
    {
        $this->isTransferable = $isTransferable;

        return $this;
    }

    public function isLoanable(): ?bool
    {
        return $this->isLoanable;
    }

    public function setLoanable(bool $isLoanable): static
    {
        $this->isLoanable = $isLoanable;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function isInLoan(): ?bool
    {
        return $this->inLoan;
    }

    public function setInLoan(bool $inLoan): static
    {
        $this->inLoan = $inLoan;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    public function getOwnerTeam(): ?Team
    {
        return $this->ownerTeam;
    }

    public function setOwnerTeam(?Team $ownerTeam): static
    {
        $this->ownerTeam = $ownerTeam;

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
