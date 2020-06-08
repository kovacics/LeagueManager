<?php


namespace App\Command;


use App\Entity\Match;
use App\Service\StandingsCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

class MatchChangeListenRedisCommand extends Command
{

    private ClientInterface $client;
    private StandingsCalculator $standingsCalculator;
    private EntityManagerInterface $entityManager;
    protected static $defaultName = 'redis:match';

    public const MATCH_CHANGE_KEY = "match_change";

    /**
     * MatchChangeListenRedisCommand constructor.
     * @param ClientInterface $client
     * @param StandingsCalculator $standingsCalculator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ClientInterface $client, StandingsCalculator $standingsCalculator, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->client = $client;
        $this->standingsCalculator = $standingsCalculator;
        $this->entityManager = $entityManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Waits on redis jobs queue.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        while (true) {
            $id = $this->client->pop(self::MATCH_CHANGE_KEY);
            if ($id) {
                /** @var Match $match */
                $match = $this->entityManager->getRepository(Match::class)->find($id);
                $this->standingsCalculator->calculateForAllMatches($match->getSeason());
                $output->write("Recalculated standings.");
                continue;
            }
        }
    }

}