<?php

namespace App\Service;

use App\Entity\MasterLeague;
use App\Entity\MasterLeaguePlayerCardRule;
use App\Entity\MasterLeaguePlayerPriceRule;
use App\Repository\MasterLeaguePlayerCardRuleRepository;
use App\Repository\MasterLeaguePlayerPriceRuleRepository;
use App\Repository\MasterLeagueRepository;
use Doctrine\ORM\EntityManagerInterface;

class MasterLeagueService
{
    public const ML_CREATED_SUCCESS_MSG = 'La liga se ha creado con exito';
    public const ML_UPDATE_SUCCESS_MSG = 'La liga se ha actualizado con exito';
    public const RULE_UPDATED_SUCCESS_MSG = 'La regla se ha actualizado con exito';
    public const RULE_CREATED_SUCCESS_MSG = 'La regla se ha creado con exito';
    public const RULE_DELETED_SUCCESS_MSG = 'La regla se ha eliminado con exito';

    public function __construct(
        private EntityManagerInterface $em,
        private MasterLeagueRepository $masterLeagueRepository,
        private MasterLeaguePlayerPriceRuleRepository $masterLeaguePlayerPriceRuleRepository,
        private MasterLeaguePlayerCardRuleRepository $masterLeaguePlayerCardRuleRepository
    ) {
    }

    public function saveMasterLeague(MasterLeague $masterLeague): void
    {
        $this->em->persist($masterLeague);
        $this->em->flush();
    }    
    
    public function updateMasterLeague(MasterLeague $masterLeague): void
    {
        $masterLeague->setUpdatedAt(new \DateTimeImmutable);
        $this->em->persist($masterLeague);
        $this->em->flush();
    }

    public function savePlayerPriceRule(MasterLeaguePlayerPriceRule $playerPriceRule, int $masterLeagueId): void
    {
        $masterLeague = $this->masterLeagueRepository->find($masterLeagueId);
        $playerPriceRule->setMasterLeague($masterLeague);

        $this->em->persist($playerPriceRule);
        $this->em->flush();
    }

    public function updatePlayerPriceRule(MasterLeaguePlayerPriceRule $playerPriceRule): void
    {
        $playerPriceRule->setUpdatedAt(new \DateTimeImmutable);
        $this->em->persist($playerPriceRule);
        $this->em->flush();
    }

    public function deletePlayerPriceRule(int $id): void
    {
        $playerPriceRule = $this->masterLeaguePlayerPriceRuleRepository->find($id);
        $this->em->remove($playerPriceRule);
        $this->em->flush();
    }

    public function savePlayerCardRule(MasterLeaguePlayerCardRule $playerCardRule, int $masterLeagueId): void
    {
        $masterLeague = $this->masterLeagueRepository->find($masterLeagueId);
        $playerCardRule->setMasterLeague($masterLeague);

        $this->em->persist($playerCardRule);
        $this->em->flush();
    }

    public function updatePlayerCardRule(MasterLeaguePlayerCardRule $playerCardRule): void
    {
        $playerCardRule->setUpdatedAt(new \DateTimeImmutable);
        $this->em->persist($playerCardRule);
        $this->em->flush();
    }

    public function deletePlayerCardRule(int $id): void
    {
        $playerCardRule = $this->masterLeaguePlayerCardRuleRepository->find($id);
        $this->em->remove($playerCardRule);
        $this->em->flush();
    }

    public function isValidPlayerPriceRule(MasterLeaguePlayerPriceRule $playerPriceRule): bool
    {
        return is_null($this->masterLeaguePlayerPriceRuleRepository->findOneByRangeRatingRange($playerPriceRule));
    }

    public function formatPlayerCardRuleRangeError(MasterLeaguePlayerPriceRule $playerPriceRule): ?string
    {
        return sprintf('Ya exista una regla que abarca el rango <b>%d - %d</b>, por favor ingrese un rango diferente', $playerPriceRule->getRatingFrom(), $playerPriceRule->getRatingTo());
    }
}
