@extends('layout')


@section('content')
    <div class="p-6">
            <table>
                <thead>
                    <tr>
                        <th>Stream</th>
                        <th>Viewer Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($streams as $stream)
                        <tr>
                            <td class="p-2">{{$stream->channel_name}}</td>
                            <td class="p-2">{{$stream->viewer_count}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
        
                           
    </div>
@endsection