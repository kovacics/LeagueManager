<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Competition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CompetitionController
 * @package App\Controller
 * @Route("/competition")
 */
class CompetitionController extends AbstractController
{

    /**
     * @Route("/{id}/seasons", methods={"GET"})
     * @param Competition $competition
     * @return Response
     */
    public function getAllSeasons(Competition $competition): Response
    {
        return $this->render("seasonsForCompetition.html.twig", ['seasons' => $competition->getSeasons(), 'competition' => $competition]);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     * @param Competition $competition
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function updateCompetition(Competition $competition, Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        // prima se name, category, rounds
        $competition->setName($data['name']);

        /** @var Category $category */
        $category = $entityManager->getRepository(Category::class)->find($data['categoryId']);
        if ($category === null) {
            throw new BadRequestHttpException("Category with given id doesn't exist.");
        }

        $competition->setCategory($category);
        $competition->setRounds($data['rounds']);

        $entityManager->persist($competition);
        $entityManager->flush();

        return new Response("Competition updated", 200);
    }
}