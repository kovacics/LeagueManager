<?php


namespace App\Service;


use App\Entity\Competition;
use App\Entity\Season;
use App\Entity\Standings;
use App\Entity\StandingsRow;
use App\Repository\SeasonRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;

class SeasonGenerator
{

    private EntityManagerInterface $entityManager;
    private MatchesGenerator $matchesGenerator;

    /**
     * SeasonGenerator constructor.
     * @param EntityManagerInterface $entityManager
     * @param MatchesGenerator $matchesGenerator
     */
    public function __construct(EntityManagerInterface $entityManager, MatchesGenerator $matchesGenerator)
    {
        $this->entityManager = $entityManager;
        $this->matchesGenerator = $matchesGenerator;
    }

    /**
     * Generira novu sezonu s natjecateljima iz posljednje sezone u natjecanju.
     *
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @param Competition $competition
     * @param MatchesGenerator $matchesGenerator
     */
    public function generateForCompetition(\DateTimeInterface $start, \DateTimeInterface $end,
                                           Competition $competition): void
    {
        $year = Carbon::instance($start)->year;
        $seasonName = $year . "/" . substr($year + 1, 2);

        $season = new Season();
        $season->setStartDate($start);
        $season->setEndDate($end);
        $season->setCompetition($competition);
        $season->setName($seasonName);


        /** @var SeasonRepository $seasonRepo */
        $seasonRepo = $this->entityManager->getRepository(Season::class);
        $lastSeason = $seasonRepo->findLast($competition->getId());


        /** @var Standings $standings */
        $standings = $this->entityManager->getRepository(Standings::class)->findBy(["season" => $lastSeason->getId()])[0];
        $competitors = $standings->getStandingsRows();

        $standingsHome = new Standings();
        $standingsHome->setType(Standings::HOME);
        $standingsAway = new Standings();
        $standingsAway->setType(Standings::AWAY);
        $standingsTotal = new Standings();
        $standingsTotal->setType(Standings::TOTAL);

        $this->entityManager->persist($season);
        $standingsHome->setSeason($season);
        $standingsAway->setSeason($season);
        $standingsTotal->setSeason($season);
        $this->entityManager->persist($standingsAway);
        $this->entityManager->persist($standingsHome);
        $this->entityManager->persist($standingsTotal);
        $this->entityManager->flush();


        foreach ($competitors as $competitor) {
            $row = new StandingsRow();
            $row->setCompetitor($competitor->getCompetitor());
            $standingsHome->addStandingsRow($row);
            $this->entityManager->persist($row);
            $this->entityManager->persist($standingsHome);

            $row = new StandingsRow();
            $row->setCompetitor($competitor->getCompetitor());
            $standingsAway->addStandingsRow($row);
            $this->entityManager->persist($row);
            $this->entityManager->persist($standingsAway);

            $row = new StandingsRow();
            $row->setCompetitor($competitor->getCompetitor());
            $standingsTotal->addStandingsRow($row);
            $this->entityManager->persist($row);
            $this->entityManager->persist($standingsTotal);

            $this->entityManager->flush();
        }

        $this->matchesGenerator->generateFromStandings($standingsTotal);
    }
}