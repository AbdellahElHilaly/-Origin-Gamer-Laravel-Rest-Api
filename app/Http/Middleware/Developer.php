<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Helpers\ApiResponceHandler;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ErorrExeptionsHandler;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Interfaces\Repository\UserRepositoryInterface;

class Developer
{
    use ApiResponceHandler;
    use ErorrExeptionsHandler;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
    }

    public function handle(Request $request, Closure $next): Response
    {
        try {

            

            $game = Game::findOrfail($request->route('game'));
            if(Auth::user()->rule->name == 'developer' && $game->user_id !== Auth::id()){
                return $this->apiResponse(NULL , false , 'You are not the owner of this game Can not Delete or Update it.' , Response::HTTP_FORBIDDEN);
            }
            return $next($request);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

}
