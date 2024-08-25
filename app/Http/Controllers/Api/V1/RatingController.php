<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function rateMovie(Request $request)
    {
        
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'integer|between:1,5',
        ]);
        $rate = Rate::create([
            'user_id' => Auth::user()->id,
            'movie_id' => $data['movie_id'],
            'rating' => $data['rating'],
        ]);

        return ApiResponseService::success($rate, "Your rate has been saved successfully", 201);
    }
}
