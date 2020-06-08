<?php

namespace App\Repository;

use App\Entity\Match;
use App\Entity\Season;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Match|null find($id, $lockMode = null, $lockVersion = null)
 * @method Match|null findOneBy(array $criteria, array $orderBy = null)
 * @method Match[]    findAll()
 * @method Match[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Match::class);
    }

    public function findFirstUnplayedMatch(Season $season): ?Match
    {
        $matches = $this->createQueryBuilder('m')
            ->andWhere('m.status = :status')
            ->setParameter('status', Match::NOT_STARTED)
            ->andWhere('m.season = :season')
            ->setParameter('season', $season->getId())
            ->orderBy('m.start', 'ASC')
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();

        if (empty($matches)) return null;
        return $matches[0];
    }

    public function findLastFiveMatchesByCompetitor(int $competitorId): array
    {
        return $this->createQueryBuilder('m')
            ->orWhere('m.homeCompetitor = :competitorId')
            ->orWhere('m.awayCompetitor = :competitorId')
            ->setParameter('competitorId', $competitorId)
            ->andWhere('m.status = :matchStatus')
            ->setParameter('matchStatus', Match::FINISHED)
            ->getQuery()
            ->setMaxResults(5)
            ->getResult();
    }
}
