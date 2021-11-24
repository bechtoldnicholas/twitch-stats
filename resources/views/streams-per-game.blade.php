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
                            <td>{{$game->name}}</td>
                            <td>{{$game->streams_count}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
        
            {!!$games->links()!!}                      
    </div>
@endsection