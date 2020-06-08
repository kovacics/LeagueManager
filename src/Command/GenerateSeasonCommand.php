<?php


namespace App\Command;


use App\Repository\CompetitionRepository;
use App\Service\SeasonGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSeasonCommand extends Command
{
    protected static $defaultName = 'season:generate';

    private SeasonGenerator $seasonGenerator;
    private CompetitionRepository $competitionRepo;

    /**
     * GenerateSeasonCommand constructor.
     * @param SeasonGenerator $seasonGenerator
     * @param CompetitionRepository $competitionRepo
     */
    public function __construct(SeasonGenerator $seasonGenerator, CompetitionRepository $competitionRepo)
    {
        $this->seasonGenerator = $seasonGenerator;
        $this->competitionRepo = $competitionRepo;
        parent::__construct();

    }


    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->seasonGenerator->generateForCompetition(new \DateTime("2019-06-01"),
            new \DateTime("2020-03-01"), $this->competitionRepo->find(1));

        return 0;
    }


}