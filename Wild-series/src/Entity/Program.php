<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=ProgramRepository::class)
 * @UniqueEntity("title", message="le titre est déja existant")
 */
class Program
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="merci de mettre un titre")
     * @Assert\Length(max="255")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="merci de rajouter un résumé ")
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Season::class, mappedBy="program")
     */
    private $Season;

    /**
     * @ORM\OneToMany(targetEntity=Episode::class, mappedBy="Program", orphanRemoval=true)
     */
    private $Episode;

    /**
     * @ORM\ManyToMany(targetEntity=Actor::class, mappedBy="programs",cascade={"persist"})
     */
    private $actors;

    public function __construct()
    {
        $this->Season = new ArrayCollection();
        $this->Episode = new ArrayCollection();
        $this->actors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

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

    /**
     * @return Collection|Season[]
     */
    public function getSeason(): Collection
    {
        return $this->Season;
    }

    public function addSeason(Season $season): self
    {
        if (!$this->Season->contains($season)) {
            $this->Season[] = $season;
            $season->setProgram($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): self
    {
        if ($this->Season->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getProgram() === $this) {
                $season->setProgram(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisode(): Collection
    {
        return $this->Episode;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->Episode->contains($episode)) {
            $this->Episode[] = $episode;
            $episode->setProgram($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->Episode->removeElement($episode)) {
            // set the owning side to null (unless already changed)
            if ($episode->getProgram() === $this) {
                $episode->setProgram(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Actor[]
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
            $actor->addProgram($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        if ($this->actors->removeElement($actor)) {
            $actor->removeProgram($this);
        }

        return $this;
    }

    
}