@extends('layout')


@section('content')
    <div class="p-6">
            <table>
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Top Stream</th>
                        <th>Viewer Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($games as $game)
                        <tr>
                            <td class="p-2">{{$game->name}}</td>
                            <td class="p-2">{{$game->channel_name}}</td>
                            <td class="p-2">{{$game->viewer_count}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
        
                           
    </div>
@endsection