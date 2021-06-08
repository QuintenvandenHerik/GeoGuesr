<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Events\UserJoinedGame;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

class UserJoined {
    public $userJoined;

    public function __construct($userJoined) {
        $this->userJoined = $userJoined;
    }
}

Route::get('/test', function () {
    UserJoinedGame::dispatch(new UserJoined("User John Doe Joined the game"));
});

Route::group(["middleware" => ["auth"]], function () {
    //get user roles, get routes of api
    Route::get("/dashboard", [
        GameController::class,
        "index",
    ])->name('dashboard');

    Route::get("/game/{id}/join", [
        GameController::class,
        "join",
    ])->name('game.join');

    Route::get("/game/{id}", [
        GameController::class,
        "show",
    ])->name('game.show');
});

require __DIR__.'/auth.php';
