<?php


namespace App\Command;


use App\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddInitialDataCommand extends Command
{

    private EntityManagerInterface $entityManager;
    protected static $defaultName = 'data:initial';

    /**
     * AddInitialDataCommand constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sport = new Sport();
        $sport->setName("football");

        $this->entityManager->persist($sport);
        $this->entityManager->flush();

        $sport = new Sport();
        $sport->setName("basketball");

        $this->entityManager->persist($sport);
        $this->entityManager->flush();

        return 0;

    }

}