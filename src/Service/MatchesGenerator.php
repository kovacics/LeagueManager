<?php


namespace App\Service;


use App\Entity\BasketballMatch;
use App\Entity\FootballMatch;
use App\Entity\Standings;
use App\Entity\StandingsRow;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class MatchesGenerator
 * @package App\Service
 */
class MatchesGenerator
{

    private EntityManagerInterface $entityManager;

    /**
     * MatchesGenerator constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Generira utakmice za natjecatelje koji se nalaze u Standingsu.
     * Ako je broj rundi koji dva natjecatelja međusobno igraju paran,
     * svaki natjecatelj će ukupno igrati jednak broj puta kod kuće (home)
     * i u gostima (away).
     * Svaki natjecatelj igra maksimalno 2 utakmice zaredom na istom terenu.
     *
     *
     * @param Standings $standings
     */
    public function generateFromStandings(Standings $standings): void
    {
        $sportName = $standings->getSeason()->getCompetition()->getCategory()->getSport()->getName();
        $competitors = $standings->getStandingsRows()->toArray();
        $rounds = $standings->getSeason()->getCompetition()->getRounds();

        $fixtures = $this->generateFromArray($competitors, $rounds);

        $n = count($fixtures);
        $days = $standings->getSeason()->getStartDate()->diff($standings->getSeason()->getEndDate())->days;
        $daysPerFixture = $days / ($n - 1);

        $matchHours = [12, 15, 18, 20];

        for ($i = 0; $i < $n; $i++) {

            $fixture = $fixtures[$i];

            $date = Carbon::instance($standings->getSeason()->getStartDate())->addRealDays($i * $daysPerFixture)->toDateTime();

            foreach ($fixture as $fixtureMatch) {

                //create new match

                if ($sportName === "football") {
                    $match = new FootballMatch();
                } else {
                    $match = new BasketballMatch();
                }

                $match->setSeason($standings->getSeason());
                $date->setTime($matchHours[rand(0, count($matchHours) - 1)], 0, 0);
                $match->setStart($date);

                /** @var StandingsRow $homeCompetitor */
                $homeCompetitor = $fixtureMatch[0];

                /** @var StandingsRow $awayCompetitor */
                $awayCompetitor = $fixtureMatch[1];

                $match->setHomeCompetitor($homeCompetitor->getCompetitor());
                $match->setAwayCompetitor($awayCompetitor->getCompetitor());
                $this->entityManager->persist($match);
                $this->entityManager->flush();
            }
        }
    }

    /**
     * Generira parove iz arraya. Elementi arraya međusobno su upareni $rounds puta.
     *
     * @param array $teams
     * @param int $rounds
     * @return array
     */
    public function generateFromArray(array $teams, int $rounds): array
    {
        $n = count($teams);
        $fixturesNumber = $n - 1;
        $gamesPerFixture = $n / 2;

        $fixtures = [];

        for ($r = 0; $r < $rounds; $r++) {

            for ($i = 0; $i < $fixturesNumber; $i++) {

                for ($j = 0; $j < $gamesPerFixture; $j++) {

                    $home = $teams[$j];
                    $away = $teams[$n - 1 - $j];

                    if ($r % 2 === 0) {
                        if ($j === 0 && $i % 2 === 0) {
                            $fixtures[$r * $fixturesNumber + $i][] = [$home, $away];
                        } else {
                            $fixtures[$r * $fixturesNumber + $i][] = [$away, $home];
                        }
                    } else {
                        if ($j === 0 && $i % 2 === 0) {
                            $fixtures[$r * $fixturesNumber + $i][] = [$away, $home];
                        } else {
                            $fixtures[$r * $fixturesNumber + $i][] = [$home, $away];
                        }
                    }

                }

                $teams = array_merge(array_slice($teams, $n / 2, $n / 2 - 1),
                    array_slice($teams, 0, $n / 2),
                    array_slice($teams, -1, 1));
            }

        }

        return $fixtures;
    }

}