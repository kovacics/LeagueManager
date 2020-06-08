<?php

namespace App\Repository;

use App\Entity\Competitor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Competitor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competitor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competitor[]    findAll()
 * @method Competitor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competitor::class);
    }
}
