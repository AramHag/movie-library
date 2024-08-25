<?php

namespace App\Services;

use App\Models\Movie;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MovieService
{

    public function listMovies(array $filters, int $perPage): LengthAwarePaginator
    {
        // Generate a unique cache key based on filters and pagination
        $cacheKey = 'movies_' . md5(json_encode($filters) . $perPage . request('page', 1));

        // Check if the cached result exists
        $movies = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($filters, $perPage) {
            // Initialize the query builder for the Book model
            $moviesQuery = Movie::query();

            // Apply genre filter if provided
            if (isset($filters['genre'])) {
                $moviesQuery->where('genre', $filters['genre']);
            }
            // Apply director filter if provided
            if (isset($filters['director'])) {
                $moviesQuery->where('director', $filters['director']);
            }

            $moviesQuery->select(['title', 'director', 'genre', 'release_year', 'description']);

            // Return the paginated result of the query
            return $moviesQuery->paginate($perPage);
        });
        return $movies;
    }



    /**
     * Create new movie with the given data
     * 
     * @param array $data
     */
    public function createMovie(array $data)
    {
        DB::beginTransaction();

        try {
            $movie = Movie::create($data);
            DB::commit();
            return $movie;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update a row from movie model with the given data
     * 
     * @param array $data
     * @param string $id find the updated movie by id
     */
    public function updateMovie(array $data ,int $id)
    {
        // Find the book by ID or fail with a 404 error if not found
        $movie = Movie::findOrFail($id);

        // Update the book with the provided data, filtering out null values
        $movie->update(array_filter($data));

        // Return the updated book
        return $movie;
    }


        /**
     * Delete a specific movie by its ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteMovie(int $id)
    {
        // Find the book by ID or fail with a 404 error if not found
        $book = Movie::findOrFail($id);

        // Delete the book
        $book->delete();
    }
}
