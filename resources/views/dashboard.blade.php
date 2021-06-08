<x-app-layout>
    <script src="{{ asset('js/dashboard/dashboard.js') }}" defer></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @isset($activeGames)
                <ul>
                @foreach($activeGames as $game)
                    <li id="game-{{ $game->id }}" class="bg-white flex items-baseline p-6 mb-6 shadow-sm sm:rounded-lg">
                        <div id="game-id" class="flex w-1/4"><p>Game #{{ $game->id }}</p></div>
                        <div id="game-status" class="flex w-1/4"><p>status:&nbsp;</p><p>{{ $game->state }}</p></div>
                        <div id="game-participants" class="flex w-1/4"><p>participants:&nbsp;</p><p class="value">{{ count($game->participants) }}</p></div>
                        @php
                            $joined = false;
                        @endphp
                        @foreach($game->participants as $participant)
                            @if($participant->user_id == Auth::id())
                                <a id="game-button" href="/game/{{ $game->id }}" class="w-1/4 flex justify-center px-4 py-1 bg-lime-500 text-sm text-white font-semibold rounded-full border border-lime-200 hover:text-lime hover:bg-lime-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-lime-600 focus:bg-lime-600 focus:ring-offset-2" type="submit">Join Game #{{$game->id}}</a>
                                @php
                                    $joined = true;
                                @endphp
                            @endif
                        @endforeach
                        @if($joined == false)
                            <a id="game-button" href="/game/{{ $game->id }}/join" class="w-1/4 flex justify-center px-4 py-1 bg-lime-500 text-sm text-white font-semibold rounded-full border border-lime-200 hover:text-lime hover:bg-lime-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-lime-600 focus:bg-lime-600 focus:ring-offset-2" type="submit">Join Game #{{$game->id}}</a>
                        @endif
                    </li>
                @endforeach
                </ul>
            @endisset
            @empty($activeGames)
                <p>No active games found...</p>
            @endempty
        </div>
    </div>
</x-app-layout>
