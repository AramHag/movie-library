<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use App\Services\ApiResponseService;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;

class MovieController extends Controller
{

    protected $movieService;
    
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filters = $request->only(['genre', 'director']);
        $perPage = $request->input('per_page', 15); 

                // Get the list of books with the specified filters and pagination
                $books = $this->movieService->listMovies($filters, $perPage);

                return ApiResponseService::paginated($books, 'Books retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request)
    {
        $data = $request->validated();

        $movie = $this->movieService->createMovie($data);

        return ApiResponseService::success($movie,"Movie created Successfully", 201 );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, int $id)
    {
        $data = $request->validated();

        $movie = $this->movieService->updateMovie($data, $id);

        return ApiResponseService::success($movie, "The movie is updated successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
                // Delete the book by its ID
                $this->movieService->deleteMovie($id);

                // Return a success response indicating the book was deleted
                return ApiResponseService::success(null, 'Movie deleted successfully');
    }
}
