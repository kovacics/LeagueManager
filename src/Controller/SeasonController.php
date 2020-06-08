<?php


namespace App\Controller;


use App\Entity\Competition;
use App\Entity\Competitor;
use App\Entity\Season;
use App\Entity\Standings;
use App\Entity\StandingsRow;
use App\Repository\CompetitorRepository;
use App\Repository\StandingsRepository;
use App\Service\MatchesGenerator;
use App\Service\PlayGameRandom;
use App\Service\StandingsCalculator;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SeasonController
 * @package App\Controller
 * @Route("/season")
 */
class SeasonController extends AbstractController
{
    /**
     * @Route("/{id}/results", methods={"GET"})
     * @param Season $season
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function getResultsForSeason(Season $season, EntityManagerInterface $entityManager): Response
    {
        /** @var StandingsRepository $standingsRepo */
        $standingsRepo = $entityManager->getRepository(Standings::class);

        $homeStandings = $standingsRepo->findOneBy(['season' => $season->getId(), 'type' => Standings::HOME]);
        $awayStandings = $standingsRepo->findOneBy(['season' => $season->getId(), 'type' => Standings::AWAY]);
        $totalStandings = $standingsRepo->findOneBy(['season' => $season->getId(), 'type' => Standings::TOTAL]);

        $homeRows = $homeStandings->getStandingsRows();
        $awayRows = $awayStandings->getStandingsRows();
        $totalRows = $totalStandings->getStandingsRows();


        return $this->render("results_for_season.html.twig", [
            'homeRows' => $homeRows, 'awayRows' => $awayRows,
            'totalRows' => $totalRows, 'season' => $season,
            'sport' => $season->getCompetition()->getCategory()->getSport()->getName(),
            'matches' => $season->getMatches()
        ]);
    }

    /**
     * @Route("/{id}/play-match", methods={"GET"})
     * @param Season $season
     * @param PlayGameRandom $playGameRandom
     * @return Response
     */
    public function playNextMatch(Season $season, PlayGameRandom $playGameRandom): Response
    {
        $matchId = $playGameRandom->playNextUnplayed($season);

        if ($matchId === null) {
            return new Response("No more match to play", 200);
        }

        return new Response("Match with id = $matchId played", 200);
    }

    /**
     * @Route("/{id}/play-all", methods={"GET"})
     * @param Season $season
     * @param PlayGameRandom $playGameRandom
     * @return Response
     */
    public function playAllMatches(Season $season, PlayGameRandom $playGameRandom): Response
    {
        $matchIds = $playGameRandom->playAllUnplayed($season);

        if (empty($matchIds)) {
            return new Response("No more matches to play", 200);
        }

        return new Response("Matches with ids = " . implode(", ", $matchIds) . " played.", 200);
    }

    /**
     * @Route("/{id}/for-competitors", methods={"POST"})
     *
     * @param Season $oldSeason
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param MatchesGenerator $matchesGenerator
     * @return Response
     */
    public function createSeasonForCompetitors(Season $oldSeason, EntityManagerInterface $entityManager,
                                               Request $request, MatchesGenerator $matchesGenerator): Response
    {

        $data = json_decode($request->getContent(), true);

        /** @var CompetitorRepository $competitorRepo */
        $competitorRepo = $entityManager->getRepository(Competitor::class);

        $competitorIds = $data['competitorIds'];

        $competitors = [];
        foreach ($competitorIds as $cid) {
            $competitor = $competitorRepo->find($cid);
            if ($competitor === null) {
                throw new BadRequestHttpException("Competition with given id doesn't exist.");
            }
            $competitors[] = $competitor;
        }

        $startDate = $data['startDate'];
        $endDate = $data['endDate'];

        $year = Carbon::instance($startDate)->year;
        $seasonName = $year . "/" . substr($year + 1, 2);

        $season = new Season();
        $season->setStartDate($startDate);
        $season->setEndDate($endDate);
        $season->setCompetition($oldSeason->getCompetition());
        $season->setName($seasonName);

        $standingsHome = new Standings();
        $standingsHome->setSeason($season);
        $standingsHome->setType(Standings::HOME);

        $standingsAway = new Standings();
        $standingsAway->setSeason($season);
        $standingsAway->setType(Standings::AWAY);

        $standingsTotal = new Standings();
        $standingsTotal->setSeason($season);
        $standingsTotal->setType(Standings::TOTAL);

        $entityManager->persist($standingsTotal);
        $entityManager->persist($standingsHome);
        $entityManager->persist($standingsAway);
        $entityManager->persist($season);

        foreach ($competitors as $c) {
            $homeStandingsRow = new StandingsRow();
            $homeStandingsRow->setCompetitor($c);
            $standingsHome->addStandingsRow($homeStandingsRow);
            $entityManager->persist($homeStandingsRow);
            $entityManager->persist($standingsHome);

            $awayStandingsRow = new StandingsRow();
            $awayStandingsRow->setCompetitor($c);
            $standingsAway->addStandingsRow($awayStandingsRow);
            $entityManager->persist($awayStandingsRow);
            $entityManager->persist($standingsAway);

            $totalStandingsRow = new StandingsRow();
            $totalStandingsRow->setCompetitor($c);
            $standingsTotal->addStandingsRow($totalStandingsRow);
            $entityManager->persist($standingsTotal);
            $entityManager->persist($totalStandingsRow);

            $entityManager->flush();
        }

        $entityManager->flush();

        $matchesGenerator->generateFromStandings($standingsTotal);

        return new Response("New season created", 200);
    }

    /**
     * @Route("/{id}/recalculate-standings", methods={"GET"})
     * @param Season $season
     * @param StandingsCalculator $standingsCalculator
     * @return Response
     */
    public function recalculateStandings(Season $season, StandingsCalculator $standingsCalculator): Response
    {
        $standingsCalculator->calculateForAllMatches($season);

        return new Response("Recalculated", 200);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     *
     * @param Season $season
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function updateSeason(Season $season, Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        // prima se name, startDate, endDate, competiton

        $season->setName($data['name']);

        /** @var Competition $competition */
        $competition = $entityManager->getRepository(Competition::class)->find($data['competitionId']);

        if ($competition === null) {
            throw new BadRequestHttpException("Competition with given id doesn't exist.");
        }

        $season->setCompetition($competition);

        try {
            $season->setStartDate(new \DateTime($data['startDate']));
            $season->setEndDate(new \DateTime($data['endDate']));
        } catch (\Exception $e) {
            throw new BadRequestHttpException("Cannot parse date.");
        }

        $entityManager->persist($competition);
        $entityManager->flush();

        return new Response("Season updated", 200);
    }


}