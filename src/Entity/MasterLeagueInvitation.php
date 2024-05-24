<?php

namespace App\Entity;

use App\Repository\MasterLeagueInvitationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterLeagueInvitationRepository::class)]
class MasterLeagueInvitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;
    
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MasterLeague $masterLeague = null;
    
    #[ORM\Column]
    private ?bool $isUsed = null;
    
    #[ORM\Column]
    private ?\DateTimeImmutable $expirationDate = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

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

    public function isUsed(): ?bool
    {
        return $this->isUsed;
    }
    
    public function setUsed(bool $isUsed): static
    {
        $this->isUsed = $isUsed;
        
        return $this;
    }
    
    public function getExpirationDate(): ?\DateTimeImmutable
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeImmutable $expirationDate): static
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }
}
