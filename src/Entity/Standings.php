<?php

namespace App\Entity;

use App\Repository\StandingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StandingsRepository::class)
 */
class Standings
{

    public const HOME = "home";
    public const AWAY = "away";
    public const TOTAL = "total";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Season::class)
     * @Groups({"common"})
     */
    private Season $season;

    /**
     * @ORM\Column(type="string", length=5)
     * @Groups({"common"})
     */
    private string $type;

    /**
     * @ORM\OneToMany(targetEntity=StandingsRow::class, mappedBy="standings")
     * @ORM\OrderBy({"points" = "DESC", "percentage" = "DESC"})
     */
    private Collection $standingsRows;


    public function __construct()
    {
        $this->standingsRows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|StandingsRow[]
     */
    public function getStandingsRows(): Collection
    {
        return $this->standingsRows;
    }

    public function addStandingsRow(StandingsRow $standingsRow): self
    {
        if (!$this->standingsRows->contains($standingsRow)) {
            $this->standingsRows[] = $standingsRow;
            $standingsRow->setStandings($this);
        }

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
