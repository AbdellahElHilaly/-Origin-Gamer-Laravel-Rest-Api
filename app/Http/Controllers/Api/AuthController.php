<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Response;
use App\Helpers\ApiResponceHandler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Exceptions\ErorrExeptionsHandler;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Interfaces\Repository\UserRepositoryInterface;

class AuthController extends Controller
{

    use ErorrExeptionsHandler;
    use ApiResponceHandler;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth:api')->except(['register','login',]);
        $this->middleware('alredy.auth')->only(['register','login']);
    }


    public function register(RegisterRequest $request)
    {
        try {
            $attributes = $request->validated();
            $result = $this->userRepository->register($attributes);
            return $this->apiResponse($result , true, 'User created successfully', Response::HTTP_CREATED );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            $result = $this->userRepository->login($credentials);
            return $this->apiResponse($result, true, 'Successfully logged in', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function logout()
    {
        try {
            $this->userRepository->logout();
            return $this->apiResponse(null, true, 'User logged out successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function editProfile(UpdateProfileRequest $request)
    {
        try {
            $attributes = $request->validated();
            $result = $this->userRepository->updateProfile($attributes);
            return $this->apiResponse($result, true, 'User profile updated successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function getProfile()
    {
        try {
            $result = $this->userRepository->getProfile();
            return $this->apiResponse($result, true, 'User profile', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function deleteProfile()
    {
        try {
            $this->userRepository->deleteProfile();
            return $this->apiResponse(null, true, 'User profile deleted successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }









}
