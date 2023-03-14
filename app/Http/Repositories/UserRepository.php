<?php
namespace App\Http\Repositories;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Interfaces\Repository\UserRepositoryInterface;


class UserRepository  implements UserRepositoryInterface {



    public function register($attributes)
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $user = User::create($attributes);
        $token = Auth::login($user);
        $data['user'] = $user;
        $data['token'] = $token;

        return new UserResource($data);
    }


    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = Auth::login($user);
            return new UserResource(['user' => $user, 'token' => $token]);
        }
        throw new \Exception('SYSTEM_CLIENT_ERROR : Invalid user input. Please check your input data and try again.');
    }


    public function updateProfile($attributes)
    {
        $user = Auth::user();

        $user->update($attributes);
        $data['user'] = $user;
        $data['token'] = Auth::login($user);
        return new UserResource($data);
    }


    public function logout()
    {
        Auth::logout();
    }

    public function getProfile()
    {
        $user = Auth::user();
        $data['user'] = $user;
        $data['token'] = Auth::login($user);
        return new UserResource($data);
    }

    public function deleteProfile()
    {
        $user = Auth::user();
        $user->delete();
    }
}

