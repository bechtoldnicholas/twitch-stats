@extends('layout')


@section('content')
    <div class="p-6">
        <h1>StreamStats</h1>      
    </div>
    <div class="p-6">
        <a href="{{route('auth-redirect')}}" style="text-decoration: underline">Login with Twitch</a>      
    </div>
@endsection