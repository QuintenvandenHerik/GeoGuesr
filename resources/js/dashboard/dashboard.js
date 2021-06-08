window.Echo.channel("dashboard").listen(".user-joined-a-game", (e) => {
    console.log(e);
    $("li#game-" + e.game.id)
        .children("#game-participants")
        .children(".value")
        .html(e.game.participants.length);
});
