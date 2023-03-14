<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Helpers\ApiResponceHandler;
use App\Http\Controllers\Controller;
use App\Exceptions\ErorrExeptionsHandler;
use App\Http\Requests\Game\GameStoreRequest;
use App\Http\Requests\Game\GameUpdateRequest;
use App\Http\Interfaces\Repository\GameRepositoryInterface;

class GameController extends Controller
{
    use ErorrExeptionsHandler;
    use ApiResponceHandler;

    protected GameRepositoryInterface $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }


    public function index()
    {
        try {
            $games  = $this->gameRepository->all();
            if($games->count()==0)return $this->apiResponse($games, true ,"No games found !" ,Response::HTTP_NOT_FOUND);
            return $this->apiResponse($games, true, "Successfully retrieved " . $games->count() . " games" , Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }

    }


    public function store(GameStoreRequest $request)
    {
        try {
            $attributes = $request->validated();
            $game = $this->gameRepository->store($attributes);
            return $this->apiResponse($game , true, 'Game created successfully', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }

    }


    public function show(string $id)
    {

        try {

            if (strpos($id, 'category=') === 0) {
                $categoryId = substr($id, strlen('category='));
                $games  = $this->gameRepository->listByCategory($categoryId);
                if($games->count()==0)return $this->apiResponse($games, true ,"No games found in this Category !" ,Response::HTTP_NOT_FOUND);
                return $this->apiResponse($games, true, "Successfully retrieved " . $games->count() . " games for this Category" , Response::HTTP_OK);
            }

            $games  = $this->gameRepository->show($id);
            return $this->apiResponse($games, true, "Successfully retrieved the game" , Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function update(GameUpdateRequest $request, string $id)
    {
        try {
            $attributes = $request->all();
            $game = $this->gameRepository->update($id, $attributes);
            return $this->apiResponse($game, true, 'Game updated successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function destroy(string $id)
    {
        try {
            if ($id == "clear") {
                $this->gameRepository->clear();
                return $this->apiResponse(null, true, 'All Games have been deleted successfully', Response::HTTP_OK);
            } else {
                $this->gameRepository->destroy($id);
                return $this->apiResponse(null, true, 'Game deleted successfully', Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }



}
