<?php

namespace App\Repository;

use App\Entity\MasterLeaguePlayerPriceRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MasterLeaguePlayerPriceRule>
 */
class MasterLeaguePlayerPriceRuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MasterLeaguePlayerPriceRule::class);
    }

    //    /**
    //     * @return MasterLeaguePlayerPriceRule[] Returns an array of MasterLeaguePlayerPriceRule objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MasterLeaguePlayerPriceRule
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findOneByRangeRatingRange(MasterLeaguePlayerPriceRule $playerPriceRule): ?MasterLeaguePlayerPriceRule
    {
        return $this->createQueryBuilder('m')
            ->where('(m.ratingFrom BETWEEN :ratingFrom AND :ratingTo)')
            ->orWhere('(m.ratingTo BETWEEN :ratingFrom AND :ratingTo)')
            ->orWhere('(m.ratingFrom <= :ratingFrom AND m.ratingTo >= :ratingTo)')
            ->andWhere('m.id != :id')
            ->setParameter('ratingFrom', $playerPriceRule->getRatingFrom())
            ->setParameter('ratingTo', $playerPriceRule->getRatingTo())
            ->setParameter('id', $playerPriceRule->getId())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
