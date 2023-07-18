<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerStoreRequest;
use App\Http\Resources\PlayerCollection;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends BaseController
{
    private PlayerService $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(new PlayerCollection(Player::all()), "Players retrieved successfully");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlayerStoreRequest $request)
    {
        $validatedData = $request->validated();

        $isPlayerExist = Player::where('name', $validatedData['name'])->where('second_name', $validatedData['second_name'])->exists();

        if($isPlayerExist){
            return $this->sendError($validatedData, "Player already exists");
        }

        $player = $this->playerService->create($validatedData);

        return $this->sendResponse(new PlayerResource($player), "Player successfully created", Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $player = Player::findOrFail($id);

        if($player instanceof Player){
            return $this->sendResponse(new PlayerResource($player), "Player retrieved successfully");
        }else{
            return $this->sendError($player, "Player does not exist", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlayerStoreRequest $request, string $id)
    {
        try {
            $player = Player::findOrFail($id);

            $validatedData = $request->validated();

            $isPlayerExist = Player::where('name', $validatedData['name'])->where('second_name', $validatedData['second_name'])->exists();

            if($isPlayerExist){
                return $this->sendError("Player already exists");
            }

            $player = $this->playerService->update($player, $validatedData);

            return $this->sendResponse($player, "Player updated successfully");

        }catch (ModelNotFoundException $exception){
            return $this->sendError('Player not found', null,Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $player = Player::findOrFail($id);

        if($player instanceof Player){
            $player->delete();
            return $this->sendResponse(new PlayerResource($player), "Player deleted successfully");
        }else{
            return $this->sendError($player, "Player does not exist", Response::HTTP_NOT_FOUND);
        }
    }
}
