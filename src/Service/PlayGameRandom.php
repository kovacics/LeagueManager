<?php


namespace App\Service;


use App\Entity\BasketballMatch;
use App\Entity\FootballMatch;
use App\Entity\Match;
use App\Entity\Score;
use App\Entity\Season;
use App\Repository\MatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlayGameRandom
{
    protected MatchRepository $matchRepository;
    protected EntityManagerInterface $entityManager;
    protected StandingsCalculator $standingsCalculator;

    /**
     * PlayGameRandom constructor.
     * @param MatchRepository $matchRepository
     * @param EntityManagerInterface $entityManager
     * @param StandingsCalculator $standingsCalculator
     */
    public function __construct(MatchRepository $matchRepository, EntityManagerInterface $entityManager, StandingsCalculator $standingsCalculator)
    {
        $this->matchRepository = $matchRepository;
        $this->entityManager = $entityManager;
        $this->standingsCalculator = $standingsCalculator;
    }

    public function playAllUnplayed(Season $season): array
    {
        /** @var Match[] $matches */
        $matches = $this->matchRepository->findBy(['season' => $season, 'status' => Match::NOT_STARTED]);

        foreach ($matches as $match) {
            $this->playMatch($match);
        }

        return array_map(fn(Match $match) => $match->getId(), $matches);
    }


    public function playNextUnplayed(Season $season): ?int
    {
        $match = $this->matchRepository->findFirstUnplayedMatch($season);
        if ($match === null) return null;

        $this->playMatch($match);
        return $match->getId();
    }

    /**
     * @param Match $match
     */
    protected function playMatch(Match $match): void
    {
        $match->setStatus(Match::FINISHED);

        $homeScore = new Score();
        $awayScore = new Score();

        switch ($match->getSeason()->getCompetition()->getCategory()->getSport()->getName()) {

            case "football":
                $homeScore->setPeriod1(rand(0, 4));
                $homeScore->setPeriod2(rand(0, 4));

                $awayScore->setPeriod1(rand(0, 4));
                $awayScore->setPeriod2(rand(0, 4));

                $homeScore->setFinal($homeScore->getPeriod1() + $homeScore->getPeriod2());
                $awayScore->setFinal($awayScore->getPeriod1() + $awayScore->getPeriod2());

                if ($homeScore->getFinal() === $awayScore->getFinal()) {
                    $match->setWinnerCode(FootballMatch::RESULT_DRAW);
                } elseif ($homeScore->getFinal() > $awayScore->getFinal()) {
                    $match->setWinnerCode(FootballMatch::RESULT_WINNER_HOME);
                } else {
                    $match->setWinnerCode(FootballMatch::RESULT_WINNER_AWAY);
                }

                break;

            case "basketball":
                $homeScore->setPeriod1(rand(15, 28));
                $homeScore->setPeriod2(rand(15, 28));
                $homeScore->setPeriod3(rand(15, 28));
                $homeScore->setPeriod4(rand(15, 28));

                $awayScore->setPeriod1(rand(15, 28));
                $awayScore->setPeriod2(rand(15, 28));
                $awayScore->setPeriod3(rand(15, 28));
                $awayScore->setPeriod4(rand(15, 28));

                $allPeriodsHome = $homeScore->getPeriod1() + $homeScore->getPeriod2() + $homeScore->getPeriod3() + $homeScore->getPeriod4();
                $allPeriodsAway = $awayScore->getPeriod1() + $awayScore->getPeriod2() + $awayScore->getPeriod3() + $awayScore->getPeriod4();

                $homeScore->setFinal($allPeriodsHome);
                $awayScore->setFinal($allPeriodsAway);

                if ($allPeriodsAway === $allPeriodsHome) {
                    $overtimeHome = rand(7, 14);
                    $overtimeAway = rand(7, 14);

                    while ($overtimeAway === $overtimeHome) {
                        $overtimeAway = rand(7, 14);
                    }

                    $homeScore->setOvertime($overtimeHome);
                    $awayScore->setOvertime($overtimeAway);
                }


                if (($homeScore->getFinal() + $homeScore->getOvertime()) < ($awayScore->getFinal() + $awayScore->getOvertime())) {
                    $match->setWinnerCode(BasketballMatch::RESULT_WINNER_AWAY);
                } else {
                    $match->setWinnerCode(BasketballMatch::RESULT_WINNER_HOME);
                }

                break;
        }

        $match->setHomeScore($homeScore);
        $match->setAwayScore($awayScore);

        $this->entityManager->persist($match);
        $this->entityManager->flush();

        $this->standingsCalculator->updateRows($match);
    }

}