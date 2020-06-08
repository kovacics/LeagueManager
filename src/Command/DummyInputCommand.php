<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Competition;
use App\Entity\CompetitionSeason;
use App\Entity\Country;
use App\Entity\Season;
use App\Entity\Sport;
use App\Entity\Standings;
use App\Entity\StandingsRow;
use App\Entity\Team;
use App\Repository\SportRepository;
use App\Service\MatchesGenerator;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DummyInputCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private MatchesGenerator $matchesGenerator;

    /**
     * InputDummyCommand constructor.
     * @param EntityManagerInterface $entityManager
     * @param MatchesGenerator $matchesGenerator
     */
    public function __construct(EntityManagerInterface $entityManager, MatchesGenerator $matchesGenerator)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->matchesGenerator = $matchesGenerator;
    }


    protected function configure()
    {
        $this
            ->setName("input:dummy")
            ->setDescription('Adds dummy data to database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // 1.  sport

        /** @var SportRepository $sportRepository */
        $sportRepository = $this->entityManager->getRepository(Sport::class);
        $sports = $sportRepository->findAll();
        $sport = $sports[rand(0, count($sports) - 1)];

        // 2. category

        $categoryName = $this->randomName(5, 7);
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => $categoryName]);
        if ($category === null) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setSport($sport);

            $this->entityManager->persist($category);
            $this->entityManager->flush();
        }

        // 3. competition

        $competitionName = $this->randomName(5, 7);
        $competition = $this->entityManager->getRepository(Competition::class)->findOneBy(['name' => $competitionName]);
        if ($competition === null) {
            $competition = new Competition();
            $competition->setName($competitionName);
            $competition->setRounds(rand(2, 4));
            $competition->setCategory($category);

            $this->entityManager->persist($competition);
            $this->entityManager->flush();
        }

        // 4. generate season, 7-11 months long

        $year = rand(2000, 2019);
        $startDate = Carbon::create($year, rand(6, 9), rand(1, 30), 12, 0, 0);

        $season = new Season();
        $season->setName("$year/" . substr($year + 1, 2));
        $season->setCompetition($competition);
        $season->setStartDate($startDate->toDate());
        $startDate->addMonthsNoOverflow(rand(7, 11));  //season lasts between 7 and 11 months
        $season->setEndDate($startDate->toDate()->setTime(23, 59, 59));
        $this->entityManager->persist($season);


        // 6. create standings for season

        $standingsHome = new Standings();
        $standingsHome->setSeason($season);
        $standingsHome->setType(Standings::HOME);

        $standingsAway = new Standings();
        $standingsAway->setSeason($season);
        $standingsAway->setType(Standings::AWAY);

        $standingsTotal = new Standings();
        $standingsTotal->setSeason($season);
        $standingsTotal->setType(Standings::TOTAL);

        $this->entityManager->persist($standingsTotal);
        $this->entityManager->persist($standingsHome);
        $this->entityManager->persist($standingsAway);
        $this->entityManager->flush();


        // create 10-16 teams

        $teamNumbers = [10, 12, 14, 16];
        $teamNum = $teamNumbers[rand(0, 3)];

        for ($i = 0; $i < $teamNum; $i++) {

            // random country
            $countryArray = Country::countries[array_rand(Country::countries)];
            $country = new Country();
            $country->setName($countryArray[Country::NAME]);
            $country->setAlpha2($countryArray[Country::ALPHA_2]);
            $country->setAlpha3($countryArray[Country::ALPHA_3]);

            // create team
            $name = $this->randomName(5, 15);
            $team = new Team();
            $team->setName($name);
            $team->setSport($sport);
            $team->setCountry($country);
            $this->entityManager->persist($team);

            // 6. create rows in standings for every team
            $homeStandingsRow = new StandingsRow();
            $homeStandingsRow->setCompetitor($team);
            $standingsHome->addStandingsRow($homeStandingsRow);

            $this->entityManager->persist($homeStandingsRow);
            $this->entityManager->persist($standingsHome);

            $awayStandingsRow = new StandingsRow();
            $awayStandingsRow->setCompetitor($team);
            $standingsAway->addStandingsRow($awayStandingsRow);

            $this->entityManager->persist($awayStandingsRow);
            $this->entityManager->persist($standingsAway);

            $totalStandingsRow = new StandingsRow();
            $totalStandingsRow->setCompetitor($team);
            $standingsTotal->addStandingsRow($totalStandingsRow);

            $this->entityManager->persist($totalStandingsRow);
            $this->entityManager->persist($standingsTotal);

            $this->entityManager->flush();
        }

        // 7. generate matches
        $this->matchesGenerator->generateFromStandings($standingsHome);

        return 0;
    }


    private function randomName($min, $max)
    {
        $length = rand($min, $max);
        $characters = 'abcdefghijklmnopqrstuvwxyz ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return ucwords($randomString);
    }
}
