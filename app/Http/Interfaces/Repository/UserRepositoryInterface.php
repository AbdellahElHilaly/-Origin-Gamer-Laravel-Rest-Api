<?php

namespace App\Http\Interfaces\Repository;

use App\Models\User;

interface UserRepositoryInterface
{
    public function register($attributes);
    public function login(array $credentials);
    public function logout();
    public function updateProfile($attributes);
    public function getProfile();
    public function deleteProfile();
}
