<?php

namespace App\Entity;

use App\Repository\MatchRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=MatchRepository::class)
 * @ORM\Table(name="`match`")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "football":"FootballMatch",
 *     "basketball":"BasketballMatch"
 * })
 */
abstract class Match
{
    public const NOT_STARTED = 0;
    public const PAUSE = 3;
    public const CANCELED = 8;
    public const FINISHED = 9;

    public const RESULT_WINNER_HOME = 1;
    public const RESULT_WINNER_AWAY = 2;
    public const RESULT_DRAW = 3;


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
    protected Competitor $homeCompetitor;

    /**
     * @ORM\ManyToOne(targetEntity=Competitor::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"common"})
     */
    private Competitor $awayCompetitor;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"common"})
     */
    private \DateTimeInterface $start;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $status = self::NOT_STARTED;

    /**
     * @ORM\ManyToOne(targetEntity=Season::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"common"})
     */
    private Season $season;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"common"})
     */
    private ?int $winnerCode = null;

    /**
     * @ORM\Embedded(class="Score")
     * @Groups({"common"})
     */
    private Score $homeScore;

    /**
     * @ORM\Embedded(class="Score")
     * @Groups({"common"})
     */
    private Score $awayScore;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomeCompetitor(): ?Competitor
    {
        return $this->homeCompetitor;
    }

    public function setHomeCompetitor(?Competitor $homeCompetitor): self
    {
        $this->homeCompetitor = $homeCompetitor;

        return $this;
    }

    public function getAwayCompetitor(): ?Competitor
    {
        return $this->awayCompetitor;
    }

    public function setAwayCompetitor(?Competitor $awayCompetitor): self
    {
        $this->awayCompetitor = $awayCompetitor;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getWinnerCode(): ?int
    {
        return $this->winnerCode;
    }

    public function setWinnerCode(?int $winnerCode): self
    {
        $this->winnerCode = $winnerCode;

        return $this;
    }

    public function getHomeScore(): ?Score
    {
        return $this->homeScore;
    }

    public function setHomeScore(Score $homeScore): self
    {
        $this->homeScore = $homeScore;

        return $this;
    }

    public function getAwayScore(): ?Score
    {
        return $this->awayScore;
    }

    public function setAwayScore(Score $awayScore): self
    {
        $this->awayScore = $awayScore;

        return $this;
    }

}
