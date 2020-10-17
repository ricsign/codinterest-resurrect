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
                {{--ranking index--}}
                @if(($users ->currentpage()-1) * $users ->perpage() + $loop->iteration == 1)
                    <th scope="row" style="color: gold">{{($users ->currentpage()-1) * $users ->perpage() + $loop->iteration}}</th>
                @elseif(($users ->currentpage()-1) * $users ->perpage() + $loop->iteration == 2)
                    <th scope="row" style="color: silver">{{($users ->currentpage()-1) * $users ->perpage() + $loop->iteration}}</th>
                @elseif(($users ->currentpage()-1) * $users ->perpage() + $loop->iteration == 3)
                    <th scope="row" style="color: #cd7f32">{{($users ->currentpage()-1) * $users ->perpage() + $loop->iteration}}</th>
                @elseif(($users ->currentpage()-1) * $users ->perpage() + $loop->iteration <= 50)
                    <th scope="row" style="color: blue">{{($users ->currentpage()-1) * $users ->perpage() + $loop->iteration}}</th>
                @else
                    <th scope="row">{{$loop->iteration}}</th>
                @endif

                <td><a href="{{url('/public/myaccount/'.$user->user->uid)}}">{{$user->user->username}} {{session()->get('user') && session()->get('user')->uid == $user->uid ? " (me)":""}}</a></td>
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
                @elseif($user->userprivil == 0)
                    <td>Coder</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <br><br>
    <div class="pagination justify-content-center">{{$users->links()}}</div>
@endsection
