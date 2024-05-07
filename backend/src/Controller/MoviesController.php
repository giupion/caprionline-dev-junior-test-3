<?php
// src/Controller/MoviesController.php

// src/Controller/MoviesController.php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    #[Route('/movies', methods: ['GET'])]
    public function list(Request $request, MovieRepository $movieRepository): JsonResponse
    {
        $sortBy = $request->query->get('sortBy', 'recent');
        $genre = $request->query->get('genre');

        // Ottieni i film ordinati e filtrati dal repository
        $movies = $movieRepository->findMoviesOrderedAndFiltered($sortBy, $genre);

        // Restituisci i dati dei film come JSON
        return new JsonResponse($movies, Response::HTTP_OK);
    }
}
