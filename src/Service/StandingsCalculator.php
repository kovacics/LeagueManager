<?php


namespace App\Service;


use App\Entity\BasketballMatch;
use App\Entity\FootballMatch;
use App\Entity\Match;
use App\Entity\Season;
use App\Entity\Standings;
use App\Entity\StandingsRow;
use App\Repository\StandingsRepository;
use App\Repository\StandingsRowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use RuntimeException;

class StandingsCalculator
{

    private EntityManagerInterface $entityManager;

    /**
     * StandingsCalculator constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function calculateForAllMatches(Season $season): void
    {
        $this->resetStandingsRowsForAllMatches($season);

        $matches = $season->getMatches();

        foreach ($matches as $match) {
            $this->updateRows($match);
        }

    }

    /**
     * @param Match $match
     */
    public function updateRows(Match $match): void
    {
        if ($match->getStatus() !== Match::FINISHED) {
            return;
        }

        /** @var StandingsRowRepository $repo */
        $repo = $this->entityManager->getRepository(StandingsRow::class);

        $season = $match->getSeason();
        $sport = $season->getCompetition()->getCategory()->getSport();

        $standingsRepository = $this->entityManager->getRepository(Standings::class);

        $homeStandings = $standingsRepository->findOneBy(["season" => $season->getId(), "type" => Standings::HOME]);
        $awayStandings = $standingsRepository->findOneBy(["season" => $season->getId(), "type" => Standings::AWAY]);
        $totalStandings = $standingsRepository->findOneBy(["season" => $season->getId(), "type" => Standings::TOTAL]);

        $homeComp = $match->getHomeCompetitor();
        $awayComp = $match->getAwayCompetitor();

        try {
            $homeRow = $repo->findOneByStandingsAndCompetitor($homeStandings->getId(), $homeComp->getId());
            $awayRow = $repo->findOneByStandingsAndCompetitor($awayStandings->getId(), $awayComp->getId());
            $totalHomeRow = $repo->findOneByStandingsAndCompetitor($totalStandings->getId(), $homeComp->getId());
            $totalAwayRow = $repo->findOneByStandingsAndCompetitor($totalStandings->getId(), $awayComp->getId());
        } catch (NonUniqueResultException $e) {
            throw new RuntimeException("Error in StandingsRow table, multiple rows for same Competitor and Standings.");
        } catch (NoResultException $e1) {
            throw new RuntimeException("Competitor row doesn't exist in Standings table.");
        }

        $homeScore = $match->getHomeScore();
        $awayScore = $match->getAwayScore();

        $homeRow->addMatch();
        $awayRow->addMatch();
        $totalHomeRow->addMatch();
        $totalAwayRow->addMatch();

        switch ($sport->getName()) {
            case "football":

                $homeScoreFull = $homeScore->getFinal();
                $awayScoreFull = $awayScore->getFinal();

                switch ($match->getWinnerCode()) {
                    case FootballMatch::RESULT_WINNER_HOME:
                        $homeRow->addWin();
                        $homeRow->addPoints(3);
                        $totalHomeRow->addWin();
                        $totalHomeRow->addPoints(3);
                        $awayRow->addLoss();
                        $totalAwayRow->addLoss();
                        break;

                    case FootballMatch::RESULT_WINNER_AWAY:
                        $homeRow->addLoss();
                        $totalHomeRow->addLoss();
                        $awayRow->addWin();
                        $awayRow->addPoints(3);
                        $totalAwayRow->addWin();
                        $totalAwayRow->addPoints(3);
                        break;

                    case FootballMatch::RESULT_DRAW:
                        $homeRow->addDraw();
                        $homeRow->addPoints(1);
                        $totalHomeRow->addDraw();
                        $totalHomeRow->addPoints(1);
                        $awayRow->addDraw();
                        $awayRow->addPoints(1);
                        $totalAwayRow->addDraw();
                        $totalAwayRow->addPoints(1);
                        break;

                    default:
                        throw new RuntimeException("Winner code has illegal value.");
                }

                break;

            case "basketball":

                $homeScoreFull = $homeScore->getFinal() + $homeScore->getOvertime() ?? 0;
                $awayScoreFull = $awayScore->getFinal() + $awayScore->getOvertime() ?? 0;

                switch ($match->getWinnerCode()) {
                    case BasketballMatch::RESULT_WINNER_HOME:
                        $homeRow->addWin();
                        $totalHomeRow->addWin();
                        $awayRow->addLoss();
                        $totalAwayRow->addLoss();
                        break;

                    case BasketballMatch::RESULT_WINNER_AWAY:
                        $homeRow->addLoss();
                        $totalHomeRow->addLoss();
                        $awayRow->addWin();
                        $totalAwayRow->addWin();
                        break;

                    default:
                        throw new RuntimeException("Winner code has illegal value.");
                }

                $homeRow->setPercentage($homeRow->getWins() / $homeRow->getMatches());
                $awayRow->setPercentage($awayRow->getWins() / $awayRow->getMatches());
                $totalHomeRow->setPercentage($totalHomeRow->getWins() / $totalHomeRow->getMatches());
                $totalAwayRow->setPercentage($totalAwayRow->getWins() / $totalAwayRow->getMatches());
        }

        $homeRow->addScoresFor($homeScoreFull);
        $homeRow->addScoresAgainst($awayScoreFull);

        $awayRow->addScoresFor($awayScoreFull);
        $awayRow->addScoresAgainst($homeScoreFull);

        $totalHomeRow->addScoresFor($homeScoreFull);
        $totalHomeRow->addScoresAgainst($awayScoreFull);

        $totalAwayRow->addScoresFor($awayScoreFull);
        $totalAwayRow->addScoresAgainst($homeScoreFull);

        $this->entityManager->persist($homeRow);
        $this->entityManager->persist($awayRow);
        $this->entityManager->persist($totalHomeRow);
        $this->entityManager->persist($totalAwayRow);
        $this->entityManager->flush();
    }

    /**
     * @param Season $season
     */
    private function resetStandingsRowsForAllMatches(Season $season): void
    {
        foreach ($season->getMatches() as $match) {

            /** @var StandingsRowRepository $repo */
            $repo = $this->entityManager->getRepository(StandingsRow::class);

            /** @var StandingsRepository $standingsRepository */
            $standingsRepository = $this->entityManager->getRepository(Standings::class);

            $homeStandings = $standingsRepository->findOneBy(["season" => $season->getId(), "type" => Standings::HOME]);
            $awayStandings = $standingsRepository->findOneBy(["season" => $season->getId(), "type" => Standings::AWAY]);
            $totalStandings = $standingsRepository->findOneBy(["season" => $season->getId(), "type" => Standings::TOTAL]);

            $homeComp = $match->getHomeCompetitor();
            $awayComp = $match->getAwayCompetitor();

            try {
                $homeRow = $repo->findOneByStandingsAndCompetitor($homeStandings->getId(), $homeComp->getId());
                $awayRow = $repo->findOneByStandingsAndCompetitor($awayStandings->getId(), $awayComp->getId());
                $totalHomeRow = $repo->findOneByStandingsAndCompetitor($totalStandings->getId(), $homeComp->getId());
                $totalAwayRow = $repo->findOneByStandingsAndCompetitor($totalStandings->getId(), $awayComp->getId());
            } catch (NonUniqueResultException $e) {
                throw new RuntimeException("Error in StandingsRow table, multiple rows for same Competitor and Standings.");
            } catch (NoResultException $e1) {
                throw new RuntimeException("Competitor row doesn't exist in Standings table.");
            }

            $homeRow->reset();
            $awayRow->reset();
            $totalHomeRow->reset();
            $totalAwayRow->reset();
        }
    }
}