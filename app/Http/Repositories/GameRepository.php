<?php
namespace App\Http\Repositories;
use App\Http\Interfaces\Repository\GameRepositoryInterface;
use App\Http\Resources\GameResource;
use App\Models\Category;
use App\Models\Game;

class GameRepository implements GameRepositoryInterface{

    public function all()
    {
        return GameResource::collection(Game::all());
    }
    public function show($id)
    {
        $game = Game::findOrFail($id);
        return new GameResource($game);
    }

    public function store($attributes)
    {
        $games = Game::create($attributes);
        return new GameResource($games);
    }


    public function clear()
    {
        $this->checkEmpty();
        Game::truncate();
    }


    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();
    }

    public function update($id , $attributes)
    {
        $game = Game::findOrFail($id);
        $game->update($attributes);
        return new GameResource($game);
    }

    public function listByCategory($categoryId){
        Category::findOrFail($categoryId);
        $games = Game::where('category_id', $categoryId)->get();
        return GameResource::collection($games);
    }



    public function checkEmpty(){
        if (Game::count() === 0) {
            throw new \Exception('Game table is already empty');
        }
    }
}

