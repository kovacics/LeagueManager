<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SeasonRepository::class)
 */
class Season
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"common"})
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=Match::class, mappedBy="season")
     */
    private Collection $matches;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"common"})
     */
    private \DateTimeInterface $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"common"})
     */
    private \DateTimeInterface $endDate;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="seasons")
     * @Groups({"common"})
     */
    private Competition $competition;


    public function __construct()
    {
        $this->matches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Match[]
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }
}
