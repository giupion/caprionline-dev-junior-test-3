<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\Table(name: 'movies')]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $imageUrl = null;

    #[ORM\Column(type: 'text')]
    private ?string $plot = null;

    #[ORM\Column(type: 'integer')]
    private ?int $year = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $duration = null;

    #[ORM\Column(type: 'integer')]
    private ?int $rating = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $wikipediaUrl = null;

    /**
     * @var Collection<int, MovieGenre>
     */
    #[ORM\OneToMany(targetEntity: MovieGenre::class, mappedBy: 'movie')]
    #[Assert\Valid()]
    private Collection $movieGenres;

    /**
     * @var Collection<int, MovieActor>
     */
    #[ORM\OneToMany(targetEntity: MovieActor::class, mappedBy: 'movie')]
    #[Assert\Valid()]
    private Collection $movieActors;

    /**
     * @var Collection<int, MovieKeyword>
     */
    #[ORM\OneToMany(targetEntity: MovieKeyword::class, mappedBy: 'movie')]
    #[Assert\Valid()]
    private Collection $movieKeywords;

    public function __construct()
    {
        $this->movieGenres = new ArrayCollection();
        $this->movieActors = new ArrayCollection();
        $this->movieKeywords = new ArrayCollection();
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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(string $plot): self
    {
        $this->plot = $plot;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getWikipediaUrl(): ?string
    {
        return $this->wikipediaUrl;
    }

    public function setWikipediaUrl(string $wikipediaUrl): self
    {
        $this->wikipediaUrl = $wikipediaUrl;

        return $this;
    }

    /**
     * @return Collection<int, MovieGenre>
     */
    public function getMovieGenres(): Collection
    {
        return $this->movieGenres;
    }

    public function addMovieGenre(MovieGenre $movieGenre): self
    {
        if (!$this->movieGenres->contains($movieGenre)) {
            $this->movieGenres->add($movieGenre);
            $movieGenre->setMovie($this);
        }

        return $this;
    }

    public function removeMovieGenre(MovieGenre $movieGenre): self
    {
        if ($this->movieGenres->removeElement($movieGenre)) {
            // set the owning side to null (unless already changed)
            if ($movieGenre->getMovie() === $this) {
                $movieGenre->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovieActor>
     */
    public function getMovieActors(): Collection
    {
        return $this->movieActors;
    }

    public function addMovieActor(MovieActor $movieActor): self
    {
        if (!$this->movieActors->contains($movieActor)) {
            $this->movieActors->add($movieActor);
            $movieActor->setMovie($this);
        }

        return $this;
    }

    public function removeMovieActor(MovieActor $movieActor): self
    {
        if ($this->movieActors->removeElement($movieActor)) {
            // set the owning side to null (unless already changed)
            if ($movieActor->getMovie() === $this) {
                $movieActor->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovieKeyword>
     */
    public function getMovieKeywords(): Collection
    {
        return $this->movieKeywords;
    }

    public function addMovieKeyword(MovieKeyword $movieKeyword): self
    {
        if (!$this->movieKeywords->contains($movieKeyword)) {
            $this->movieKeywords->add($movieKeyword);
            $movieKeyword->setMovie($this);
        }

        return $this;
    }

    public function removeMovieKeyword(MovieKeyword $movieKeyword): self
    {
        if ($this->movieKeywords->removeElement($movieKeyword)) {
            // set the owning side to null (unless already changed)
            if ($movieKeyword->getMovie() === $this) {
                $movieKeyword->setMovie(null);
            }
        }

        return $this;
    }
}
