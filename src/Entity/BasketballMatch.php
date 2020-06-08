<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class BasketballMatch extends Match
{

    public const FIRST_QUARTER = 4;
    public const SECOND_QUARTER = 5;
    public const THIRD_QUARTER = 6;
    public const FOURTH_QUARTER = 7;
    public const OVERTIME = 10;

}
