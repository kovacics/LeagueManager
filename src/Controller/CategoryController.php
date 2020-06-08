<?php


namespace App\Controller;


use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/category")
 */
class CategoryController extends AbstractController
{

    /**
     * @Route("/{id}/competitions")
     * @param Category $category
     * @return Response
     */
    public function getAllCompetitions(Category $category): Response
    {
        return $this->render("competitions_for_category.html.twig", ['category' => $category, 'competitions' => $category->getCompetitions()]);
    }

}