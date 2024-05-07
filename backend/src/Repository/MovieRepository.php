<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * Get movies ordered by specified criteria and filtered by genre.
     * 
     * @param string $sortBy The criteria to sort movies by (e.g., "recent", "rating").
     * @param string|null $genre The genre to filter movies by.
     * @return Movie[] The array of Movie objects.
     */
    public function findMoviesOrderedBy(string $sortBy, ?string $genre = null): array
    {
        $qb = $this->createQueryBuilder('m');

        switch ($sortBy) {
            case 'recent':
                $qb->orderBy('m.releaseDate', 'DESC');
                break;
            case 'rating':
                $qb->orderBy('m.rating', 'DESC');
                break;
            default:
                throw new \InvalidArgumentException("Invalid sorting criteria: $sortBy");
        }

        if ($genre) {
            $qb->andWhere('m.genre = :genre')
               ->setParameter('genre', $genre);
        }

        return $qb->getQuery()->getResult();
    }
}
