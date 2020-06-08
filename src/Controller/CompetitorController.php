<?php


namespace App\Controller;


use App\Entity\Competitor;
use App\Entity\Country;
use App\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CompetitorController
 * @package App\Controller
 * @Route("/competitor")
 */
class CompetitorController extends AbstractController
{

    /**
     * @Route("/{id}", methods={"PUT"})
     * @param Competitor $competitor
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function updateMatch(Competitor $competitor, Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        // prima se name, sport, country

        $competitor->setName($data['name']);

        /** @var Sport $sport */
        $sport = $entityManager->getRepository(Sport::class)->find($data['sportId']);
        if ($sport === null) {
            throw new BadRequestHttpException("Sport with given id doesn't exist.");
        }

        $competitor->setSport($sport);

        $countryAlpha2 = $data['countryAlpha2'];

        $countryData = Country::countries[$countryAlpha2] ?? null;
        if ($countryData === null) {
            throw new BadRequestHttpException("Country with given alpha2 doesn't exist");
        }

        $country = new Country();
        $country->setAlpha2($countryAlpha2);
        $country->setAlpha3($countryData[Country::ALPHA_3]);
        $country->setName($countryData[Country::NAME]);
        $competitor->setCountry($country);


        $entityManager->persist($competitor);
        $entityManager->flush();

        return new Response("Competitor updated", 200);
    }


}