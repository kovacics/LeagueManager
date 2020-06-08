<?php


namespace App\Controller;


use App\Entity\Standings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StandingsRowController
 * @package App\Controller
 *
 * @Route("/standings-row")
 */
class StandingsRowController extends AbstractController
{
    /**
     * @Route("/standings/{id}", methods={"GET"})
     *
     * @param Standings $standings
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function getAllForStandings(Standings $standings, EntityManagerInterface $entityManager): JsonResponse
    {
        $rows = $standings->getStandingsRows()->toArray();

        return $this->json($rows, 200, [], ['groups' => ['common']]);
    }

}