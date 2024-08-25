<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\ApiResponseService;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public $authService;


    /**
     * Constructor of AuthService
     *  
     * @param AuthService $authService(object)
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        
        $response = $this->authService->login($credentials);

        if($response['status'] === 'error')
        {
            return ApiResponseService::error($response['message'], $response['code']);
        }

        return ApiResponseService::success([
            'user' => $response['user'],
            'authorisation' => [
                'token' => $response['token'],
                'type' => 'bearer',
            ],
        ], $response['code']);

    }


    /**
     * Register New user
     * 
     * @param RegisterRequest $request : form request
     * @return JsonResponse 
     */

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->register($data);

        return ApiResponseService::success([
            'user' => $response['user'],
            'authorisation' => [
                'token' => $response['token'],
                'type' => 'bearer',
            ],
        ], 'User created successfully', $response['code']);
    }


    /**
     * 
     * Logout the current user.
     * 
     * @return JsonResponse
     */

    public function logout()
    {
        $response = $this->authService->logout();

        return ApiResponseService::success(null, $response['message'], $response['code']);
    }

}
