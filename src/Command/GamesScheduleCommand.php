<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GamesScheduleCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName("matches:schedule")
            ->setDescription('Test command for matches scheduling algorithm.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $teams = range(1, 8);

        $n = count($teams);
        $rounds = $n - 1;
        $gamesPerFixture = $n / 2;

        $file = fopen("utakmice.txt", 'w');

        for ($r = 0; $r < 2; $r++) {

            for ($i = 0; $i < $rounds; $i++) {

                for ($j = 0; $j < $gamesPerFixture; $j++) {
                    $home = $teams[$j];
                    $away = $teams[$n - 1 - $j];

                    if ($r % 2 === 0) {
                        if ($j === 0 && $i % 2 === 0) {
                            $output->write("$home - $away\n");
                            fwrite($file, "$home - $away\n");

                        } else {
                            $output->write("$away - $home\n");
                            fwrite($file, "$away - $home\n");


                        }
                    } else {
                        if ($j === 0 && $i % 2 === 0) {
                            $output->write("$away - $home\n");
                            fwrite($file, "$away - $home\n");

                        } else {
                            $output->write("$home - $away\n");
                            fwrite($file, "$home - $away\n");
                        }
                    }

                }

                $teams = array_merge(array_slice($teams, $n / 2, $n / 2 - 1),
                    array_slice($teams, 0, $n / 2),
                    array_slice($teams, -1, 1));

                $output->write("\n");
//                file_put_contents("utakmice.txt", "\n", FILE_APPEND);
                fwrite($file, "\n");
            }

            $output->write(str_repeat("=", 15));
            $output->write("\n\n");
            fwrite($file, str_repeat("=", 15));
            fwrite($file, "\n\n");
        }

        fclose($file);

//        $output->write(print_r($this->executeGeneric([1,2,3,4])));

        return 0;

    }
}
