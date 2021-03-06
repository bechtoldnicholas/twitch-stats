@extends('layout')


@section('content')
    <div class="p-6">
            <table>
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Stream Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($games as $game)
                        <tr>
                            <td class="p-2">{{$game->name}}</td>
                            <td class="p-2">{{$game->streams_count}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
        
            {!!$games->links()!!}                      
    </div>
@endsection