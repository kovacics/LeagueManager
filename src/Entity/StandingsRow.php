<?php

namespace App\Entity;

use App\Repository\StandingsRowRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StandingsRowRepository::class)
 */
class StandingsRow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Competitor::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"common"})
     */
    private Competitor $competitor;

    /**
     * @ORM\ManyToOne(targetEntity=Standings::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Standings $standings;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $matches = 0;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $wins = 0;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $losses = 0;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $scoresFor = 0;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $scoresAgainst = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"common"})
     */
    private ?int $draws = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"common"})
     */
    private ?int $points = null;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"common"})
     */
    private ?float $percentage = null;


    public function reset(): void
    {
        $this->matches = 0;
        $this->wins = 0;
        $this->losses = 0;
        $this->scoresFor = 0;
        $this->scoresAgainst = 0;
        $this->draws = null;
        $this->points = null;
        $this->percentage = null;
    }

    public function addWin(): void
    {
        $this->wins++;
    }

    public function addLoss(): void
    {
        $this->losses++;
    }

    public function addDraw(): void
    {
        $this->draws++;
    }

    public function addMatch(): void
    {
        $this->matches++;
    }

    public function addScoresFor(int $score): void
    {
        $this->scoresFor += $score;
    }

    public function addScoresAgainst(int $score): void
    {
        $this->scoresAgainst += $score;
    }

    public function addPoints(int $points): void
    {
        $this->points += $points;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetitor(): ?Competitor
    {
        return $this->competitor;
    }

    public function setCompetitor(?Competitor $competitor): self
    {
        $this->competitor = $competitor;

        return $this;
    }

    public function getStandings(): ?Standings
    {
        return $this->standings;
    }

    public function setStandings(?Standings $standings): self
    {
        $this->standings = $standings;

        return $this;
    }

    public function getMatches(): ?int
    {
        return $this->matches;
    }

    public function setMatches(int $matches): self
    {
        $this->matches = $matches;

        return $this;
    }

    public function getWins(): ?int
    {
        return $this->wins;
    }

    public function setWins(int $wins): self
    {
        $this->wins = $wins;

        return $this;
    }

    public function getLosses(): ?int
    {
        return $this->losses;
    }

    public function setLosses(int $losses): self
    {
        $this->losses = $losses;

        return $this;
    }

    public function getScoresFor(): ?int
    {
        return $this->scoresFor;
    }

    public function setScoresFor(int $scoresFor): self
    {
        $this->scoresFor = $scoresFor;

        return $this;
    }

    public function getScoresAgainst(): ?int
    {
        return $this->scoresAgainst;
    }

    public function setScoresAgainst(int $scoresAgainst): self
    {
        $this->scoresAgainst = $scoresAgainst;

        return $this;
    }

    public function getDraws(): ?int
    {
        return $this->draws;
    }

    public function setDraws(?int $draws): self
    {
        $this->draws = $draws;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    public function setPercentage(?float $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }
}
