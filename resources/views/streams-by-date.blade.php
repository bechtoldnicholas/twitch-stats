@extends('layout')


@section('content')
    <div class="p-6">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Stream Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($streams as $start_date => $stream)
                        <tr>
                            <td class="p-2">{{$start_date}}</td>
                            <td class="p-2">{{$stream->count()}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
        
                           
    </div>
@endsection