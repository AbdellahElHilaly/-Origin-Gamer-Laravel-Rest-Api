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
            $user = $this->getAuth();
            $token = Auth::login($user);
            return new UserResource(['user' => $user, 'token' => $token]);
        }
        throw new \Exception('SYSTEM_CLIENT_ERROR : Invalid user input. Please check your input data and try again.');
    }


    public function updateProfile($attributes)
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $user = $this->getAuth();
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
        $user = $this->getAuth();
        $data['user'] = $user;
        $data['token'] = Auth::login($user);
        return new UserResource($data);
    }

    public function myGames()
    {
        $user = Auth::user();
        return $user->games()->get();
    }


    public function deleteProfile()
    {
        $user = $this->getAuth();
        $user->delete();
    }

    private function getAuth()
    {
        $user = Auth::user();
        if($user) return $user;
        throw new \Exception("SYSTEM_CLIENT_ERROR : we can't find any user authentified please log out and log in angain. ");
    }
}

