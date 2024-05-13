<?php

namespace App\Entity;

use App\Repository\MasterLeagueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterLeagueRepository::class)]
class MasterLeague
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $initialBudget = null;

    #[ORM\Column]
    private ?int $minPlayers = null;

    #[ORM\Column]
    private ?int $playersLimit = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\OneToMany(targetEntity: Team::class, mappedBy: 'masterLeague', orphanRemoval: true)]
    private Collection $teams;

    /**
     * @var Collection<int, MasterLeaguePlayerPriceRule>
     */
    #[ORM\OneToMany(targetEntity: MasterLeaguePlayerPriceRule::class, mappedBy: 'masterLeague', orphanRemoval: true)]
    private Collection $playerPriceRules;

    /**
     * @var Collection<int, MasterLeaguePlayerCardRule>
     */
    #[ORM\OneToMany(targetEntity: MasterLeaguePlayerCardRule::class, mappedBy: 'masterLeague', orphanRemoval: true)]
    private Collection $playerCardRules;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->playerPriceRules = new ArrayCollection();
        $this->playerCardRules = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable;
        $this->updatedAt = new \DateTimeImmutable;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getInitialBudget(): ?int
    {
        return $this->initialBudget;
    }

    public function setInitialBudget(int $initialBudget): static
    {
        $this->initialBudget = $initialBudget;

        return $this;
    }

    public function getMinPlayers(): ?int
    {
        return $this->minPlayers;
    }

    public function setMinPlayers(int $minPlayers): static
    {
        $this->minPlayers = $minPlayers;

        return $this;
    }

    public function getPlayersLimit(): ?int
    {
        return $this->playersLimit;
    }

    public function setPlayersLimit(int $playersLimit): static
    {
        $this->playersLimit = $playersLimit;

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

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setMasterLeague($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getMasterLeague() === $this) {
                $team->setMasterLeague(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MasterLeaguePlayerPriceRule>
     */
    public function getPlayerPriceRules(): Collection
    {
        return $this->playerPriceRules;
    }

    public function addPlayerPriceRule(MasterLeaguePlayerPriceRule $playerPriceRule): static
    {
        if (!$this->playerPriceRules->contains($playerPriceRule)) {
            $this->playerPriceRules->add($playerPriceRule);
            $playerPriceRule->setMasterLeague($this);
        }

        return $this;
    }

    public function removePlayerPriceRule(MasterLeaguePlayerPriceRule $playerPriceRule): static
    {
        if ($this->playerPriceRules->removeElement($playerPriceRule)) {
            // set the owning side to null (unless already changed)
            if ($playerPriceRule->getMasterLeague() === $this) {
                $playerPriceRule->setMasterLeague(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MasterLeaguePlayerCardRule>
     */
    public function getPlayerCardRules(): Collection
    {
        return $this->playerCardRules;
    }

    public function addPlayerCardRule(MasterLeaguePlayerCardRule $playerCardRule): static
    {
        if (!$this->playerCardRules->contains($playerCardRule)) {
            $this->playerCardRules->add($playerCardRule);
            $playerCardRule->setMasterLeague($this);
        }

        return $this;
    }

    public function removePlayerCardRule(MasterLeaguePlayerCardRule $playerCardRule): static
    {
        if ($this->playerCardRules->removeElement($playerCardRule)) {
            // set the owning side to null (unless already changed)
            if ($playerCardRule->getMasterLeague() === $this) {
                $playerCardRule->setMasterLeague(null);
            }
        }

        return $this;
    }
}
