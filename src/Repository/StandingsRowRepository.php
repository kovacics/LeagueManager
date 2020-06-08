<?php

namespace App\Repository;

use App\Entity\StandingsRow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StandingsRow|null find($id, $lockMode = null, $lockVersion = null)
 * @method StandingsRow|null findOneBy(array $criteria, array $orderBy = null)
 * @method StandingsRow[]    findAll()
 * @method StandingsRow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandingsRowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StandingsRow::class);
    }

    /**
     * @param $standingsId
     * @param $competitorId
     * @return StandingsRow|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function findOneByStandingsAndCompetitor($standingsId, $competitorId): ?StandingsRow
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.standings = :sid')
            ->setParameter('sid', $standingsId)
            ->andWhere('r.competitor = :cid')
            ->setParameter('cid', $competitorId)
            ->getQuery()
            ->getSingleResult();
    }


    public function findAllBySeason(int $seasonId): array
    {

        return $this->createQueryBuilder('r')
            ->innerJoin('r.standings', 's', Join::WITH, 'r.standings = s')
            ->innerJoin('s.season', 'ss', Join::WITH, 's.season = ss')
            ->where('ss = :sid')
            ->setParameter("sid", $seasonId)
            ->getQuery()
            ->getResult();
    }
}
