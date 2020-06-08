<?php


namespace App\Controller;


use App\Entity\Season;
use App\Entity\Standings;
use App\Repository\StandingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StandingsController
 * @package App\Controller
 *
 * @Route("/standings")
 */
class StandingsController extends AbstractController
{
    /**
     * @Route("/season/{id}", methods={"GET"})
     * @param Season $season
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function getStandingsForSeason(Season $season, EntityManagerInterface $entityManager): JsonResponse
    {
        /** @var StandingsRepository $standingsRepo */
        $standingsRepo = $entityManager->getRepository(Standings::class);

        $standings = $standingsRepo->findBy(['season' => $season->getId()]);

        return $this->json($standings, 200, [], ['groups' => ['common']]);
    }

}