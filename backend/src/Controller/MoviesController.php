<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Movie;
use App\Entity\Genre;
use App\Entity\MovieGenre;

#[Route('/movies', name: 'movies_')]
class MoviesController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer
    ) {}

    // Get movie list
    #[Route('', methods: ['GET'], name: 'list')]
    public function list(): JsonResponse
    {
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();
        $data = $this->serializer->serialize($movies, "json", ["groups" => "default"]);

        return new JsonResponse($data, json: true);
    }

    // Sort movies
    #[Route('/{orderBy}', methods: ['GET'], requirements: ['orderBy'=>'(release|rating)'], name: 'sort')]
    public function sort(string $orderBy): JsonResponse
    {
        $movieRepository = $this->entityManager->getRepository(Movie::class);
        $movies = [];

        if($orderBy == 'release')
            $movies = $movieRepository->findBy([], ['releaseDate' => 'DESC']);
        elseif ($orderBy == 'rating')
            $movies = $movieRepository->findBy([], ['rating' => 'DESC']);

        $data = $this->serializer->serialize($movies, "json", ["groups" => "default"]);

        return new JsonResponse($data, json: true);
    }

    // Get list of movies for given genre
    #[Route('/{genre}', methods: ['GET'], name: 'genre_list')]
    public function listByGenre(string $genre): JsonResponse
    {
        $genre = $this->entityManager->getRepository(Genre::class)->findOneByName($genre);
        
        if(!$genre)
            return new JsonResponse('[]', json:true);

        $movieGenreRepository = $this->entityManager->getRepository(MovieGenre::class);
        $movies = [];

        $movieForGenre = $movieGenreRepository->findByGenreIdJoinedToMovie($genre->getId());
        
        foreach($movieForGenre as $movieData)
            $movies[] = $movieData->getMovie();

        $data = $this->serializer->serialize($movies, "json", ["groups" => "default"]);

        return new JsonResponse($data, json:true);
    }

    // Get sorted list of movies for given genre
    #[Route('/{genre}/{orderBy}', methods: ['GET'], name: 'genre_sort')]
    public function sortByGenre(string $genre, string $orderBy): JsonResponse
    {
        $genre = $this->entityManager->getRepository(Genre::class)->findOneByName($genre);

        if(!$genre)
            return new JsonResponse('[]', json:true);

        $movieGenreRepository = $this->entityManager->getRepository(MovieGenre::class);
        $movies = [];
        $movieForGenre = [];

        if($orderBy == 'release')
            $movieForGenre = $movieGenreRepository->findByGenreIdJoinedToMovie($genre->getId(), orderBy: ['c.releaseDate' => 'DESC']);
        elseif ($orderBy == 'rating')
            $movieForGenre = $movieGenreRepository->findByGenreIdJoinedToMovie($genre->getId(), orderBy: ['c.rating' => 'DESC']);

        foreach($movieForGenre as $movieData)
            $movies[] = $movieData->getMovie();

        $data = $this->serializer->serialize($movies, "json", ["groups" => "default"]);

        return new JsonResponse($data, json:true);
    }
}