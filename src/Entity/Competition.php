<?php

namespace App\Entity;

use App\Repository\CompetitionRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompetitionRepository::class)
 */
class Competition
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
     * @ORM\Column(type="string", length=255)
     * @Groups({"common"})
     */
    private string $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="competitions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"common"})
     */
    private Category $category;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"common"})
     */
    private int $rounds;

    /**
     * @ORM\OneToMany(targetEntity=Season::class, mappedBy="competition")
     */
    private Collection $seasons;


    public function __construct()
    {
        $this->seasons = new ArrayCollection();
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

        $slugify = Slugify::create();
        $this->slug = $slugify->slugify($name);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getRounds(): ?int
    {
        return $this->rounds;
    }

    public function setRounds(int $rounds): self
    {
        $this->rounds = $rounds;

        return $this;
    }

    /**
     * @return Collection|Season[]
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }
}
