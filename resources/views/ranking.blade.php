{{--This is the main area of all users page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/ranking.css')}}">

    <h2 class="title">Global Ranking</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Ranking</th>
            <th scope="col">Username</th>
            <th scope="col">Total Acceptance</th>
            <th scope="col">Acceptance Rate</th>
            <th scope="col">Codinterest Level</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td><a href="{{url('/public/myaccount/'.$user->user->uid)}}">{{$user->user->username}}</a></td>
                <td>{{$user->userac}}</td>
                @if($user->usersubmission == 0)
                    <td>N/A</td>
                @else
                    <td>{{floor($user->userac/$user->usersubmission*100)}}%</td>
                @endif

                @if($user->userprivil == 3)
                    <td style="color: red">Red Coder</td>
                @elseif($user->userprivil == 2)
                    <td style="color: gold">Gold Coder</td>
                @elseif($user->userprivil == 1)
                    <td style="color: silver">Silver Coder</td>
                @else
                    <td>Coder</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
