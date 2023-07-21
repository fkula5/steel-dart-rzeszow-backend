<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\Http\Resources\GameCollection;
use App\Http\Resources\GameResource;
use App\Http\Resources\PlayerResource;
use App\Models\Game;
use App\Models\Player;
use App\Services\GameService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GameController extends BaseController
{
    public function __construct(private GameService $gameService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(new GameCollection(Game::all()), "Games retrieved successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GameStoreRequest $request)
    {
        $validatedData = $request->validated();

        $game = $this->gameService->store($validatedData);

        return $this->sendResponse(new GameResource($game), "Game successfully created", Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::findOrFail($id);

        if($game instanceof Game){
            return $this->sendResponse(new GameResource($game), "Game retrieved successfully");
        }else{
            return $this->sendError($game, "Game does not exist", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
