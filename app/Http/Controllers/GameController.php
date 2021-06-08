<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Events\UserJoinedGame;
use App\Events\UserJoinedAGame;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeGames = Game::all()->whereIn('state', ['active','waiting']);
        return view('dashboard')->with('activeGames', $activeGames);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game, $id)
    {
        $game = Game::findOrFail($id);
        $participants = $game->participants;
        foreach ($participants as $participant) {
            if ($participant->user->id == Auth::id()) {
                return view('game')->with('currentGame', $game);
            }
        }
        return redirect()->route('game.join', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }

    /**
     * Join and Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function join($id)
    {
        $game = Game::findOrFail($id);
        if ($game->state != 'waiting') {
            return redirect()->route('dashboard');
        }

        foreach ($game->participants as $p) {
            if ($p->user->id == Auth::id()) {
                return redirect()->route('game.show', ['id' => $id]);
            }
        }

        $user = Auth::user();
        $participant = $user->participants()->create();
        $game->participants()->save($participant);

        $userJoined = $user->name . " Joined the game!";
        event(new UserJoinedAGame($userJoined, $user, $game));

        return redirect()->route('game.show', ['id' => $id]);
    }
}
