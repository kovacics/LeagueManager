<?php

namespace App\Entity;

use App\Repository\CompetitorRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompetitorRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "team":"Team",
 *     "person":"Person",
 *     "pair":"Pair"
 * })
 */
abstract class Competitor
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
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="competitors")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"common"})
     */
    private Sport $sport;

    /**
     * @ORM\Embedded(class="Country")
     * @Groups({"common"})
     */
    private Country $country;


    public function __construct()
    {
        $this->country = new Country();
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

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
