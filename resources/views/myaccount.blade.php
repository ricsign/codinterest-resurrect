{{--This is the main area of index page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/myaccount')}}">
    <div class="main-block">
        <h1>User Profile</h1>
        {{--Please redesign this!--}}
        <ul>
            <li>User ID: {{$user->uid}}</li>
            <li>Username: {{$user->username}}</li>
            <li>Coins: {{$user_info->usercoins}}</li>
            <li>Total AC: {{$user_info->userac}}</li>
            <li>Total Submission: {{$user_info->usersubmission}}</li>
        </ul>
        @if($is_signed)
            <button class="btn btn-danger btn-lg" onclick="conf()">Sign Out</button>
        @endif
    </div>

    <script>
        function conf() {
            if(confirm('Are you sure to sign out? Your session will be closed.'))
                location = '/protected/signout';
        }
    </script>
@endsection
