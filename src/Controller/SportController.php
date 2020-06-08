<?php


namespace App\Controller;


use App\Entity\Sport;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SportController
 * @package App\Controller
 *
 * @Route("/sport")
 */
class SportController extends AbstractController
{

    /**
     * @Route("/categories", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function getCategoriesForAllSports(EntityManagerInterface $entityManager): Response
    {
        /** @var SportRepository $sportRepo */
        $sportRepo = $entityManager->getRepository(Sport::class);

        $sports = $sportRepo->findAll();

        $sportsArray = [];
        foreach ($sports as $sport) {
            $sportsArray[$sport->getName()] = $sport->getCategories();
        }

        return $this->render("categoriesForAllSports.html.twig", ['sportsArray' => $sportsArray]);
    }

    /**
     * @Route("/{slug}/categories", methods={"GET"})
     * @param Sport $sport
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function getAllCategoriesForSport(Sport $sport, EntityManagerInterface $entityManager): Response
    {
        if ($sport === null) {
            throw new NotFoundHttpException("Sport doesn't exist.");
        }

        return $this->render("categoriesForSport.html.twig", ['categories' => $sport->getCategories(), 'sport' => $sport]);
    }

}