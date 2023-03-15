<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\ApiResponceHandler;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Guest
{
    use ApiResponceHandler;

    public function handle(Request $request, Closure $next): Response
    {
        $controllerName = explode('\\', $request->route()->getActionName());
        $modelName = explode('@', end($controllerName))[0];
        $methodeName = explode('@', end($controllerName))[1];
        $controllerName = explode('@', end($controllerName))[0];



        if(Auth::user()->rule->name == 'guest'){
            return $this->apiResponse($request->route(), false, "you din't have a permition to  do this operation ", Response::HTTP_BAD_REQUEST);
        }
        return $next($request);
    }
}
