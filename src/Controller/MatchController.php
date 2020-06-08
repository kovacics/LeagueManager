<?php

namespace App\Controller;

use App\Entity\Competitor;
use App\Entity\Match;
use App\Entity\Score;
use App\Repository\CompetitorRepository;
use App\Repository\MatchRepository;
use App\Service\StandingsCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MatchController
 * @package App\Controller
 *
 * @Route("/match")
 */
class MatchController extends AbstractController
{

    /**
     * @Route("/{id}", methods={"PUT"})
     * @param Match $match
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param StandingsCalculator $standingsCalculator
     * @return Response
     */
    public function updateMatch(Match $match, Request $request, EntityManagerInterface $entityManager,
                                StandingsCalculator $standingsCalculator): Response
    {
        $data = json_decode($request->getContent(), true);

        // prima se status, datum početka, rezultati po timovima

        $match->setStatus($data['status']);

        if ($match->getStatus() !== Match::FINISHED && $data['status'] === Match::FINISHED) {
            $standingsCalculator->updateRows($match);
        }

        try {
            $match->setStart(new \DateTime($data['start']));
        } catch (\Exception $e) {
            throw new BadRequestHttpException("Cannot parse date.");
        }

        $score = new Score();
        $homeScore = $data['homescore'];

        $score->setPeriod1($homeScore['period1'] ?? null);
        $score->setPeriod2($homeScore['period2'] ?? null);
        $score->setPeriod3($homeScore['period3'] ?? null);
        $score->setPeriod4($homeScore['period4'] ?? null);
        $score->setFinal($homeScore['final'] ?? null);
        $score->setOvertime($homeScore['overtime'] ?? null);

        $match->setHomeScore($score);

        $score = new Score();
        $awayScore = $data['awayscore'];

        $score->setPeriod1($awayScore['period1'] ?? null);
        $score->setPeriod2($awayScore['period2'] ?? null);
        $score->setPeriod3($awayScore['period3'] ?? null);
        $score->setPeriod4($awayScore['period4'] ?? null);
        $score->setFinal($awayScore['final'] ?? null);
        $score->setOvertime($awayScore['overtime'] ?? null);

        $match->setAwayScore($score);

        $entityManager->persist($match);
        $entityManager->flush();

        return new Response("Match updated", 200);
    }

    /**
     * @Route("/for-all-competitors", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function getLastFiveMatchesForAllCompetitors(EntityManagerInterface $entityManager): JsonResponse
    {
        /** @var CompetitorRepository $competitorRepo */
        $competitorRepo = $entityManager->getRepository(Competitor::class);

        $competitors = $competitorRepo->findAll();

        /** @var MatchRepository $matchRepo */
        $matchRepo = $entityManager->getRepository(Match::class);

        $matches = [];
        foreach ($competitors as $competitor) {
            $competitorMatches = $matchRepo->findLastFiveMatchesByCompetitor($competitor->getId());
            $matches[$competitor->getId()] = $competitorMatches;
        }

        return $this->json($matches, 200, [], ['groups' => ['common']]);
    }


    /**
     * @Route("/{id}", methods={"GET"})
     * @param Match $match
     * @return JsonResponse
     */
    public function getMatch(Match $match): JsonResponse
    {
        return $this->json($match, 200, [], ['groups' => ['common']]);
    }
}
