<?php

namespace App\Entity;

use App\Repository\FootballRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class FootballMatch extends Match
{

    public const FIRST_HALF = 1;
    public const SECOND_HALF = 2;
}
