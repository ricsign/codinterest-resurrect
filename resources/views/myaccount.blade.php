{{--This is the main area of index page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/myaccount.css')}}">
    {{--Side Navigation Bar--}}
    <div class="sidenav">
        <a href="#user-sign">Basic</a>
        <a href="#user-info">Codinterest</a>
        @if($is_signed)
            <a href="#user-account">Account</a>
        @endif
    </div>

    {{--Main Block--}}
    <div class="main-block">
        <h1>User Profile</h1>
        {{--User Basic Information--}}
        <div id="user-sign">
            <h3>Basic Information</h3>
            <div><img src="{{asset('imgs/site/userprivil'.$user_info->userprivil.'.png')}}" alt=""></div>
            <ul>
                <li>User ID: <span class="badge badge-pill badge-success">{{$user->uid}}</span></li>
                <li>Username: <span class="badge badge-pill badge-success">{{$user->username}}</span></li>
                <li>Account Created At: <span class="badge badge-pill badge-success">{{date('Y-m-d', strtotime($user->created_at))}}</span></li>
            </ul>
        </div>
        {{--Codinterest User Stat/User Info--}}
        <hr>
        <div id="user-info">
            <h3>Codinterest Statistics</h3>
            @if($user_info->userprivil == 3)
                <li>User Level: <span style="color: red">Red Coder</span></li>
            @elseif($user_info->userprivil == 2)
                <li>User Level: <span style="color: gold">Gold Coder</span></li>
            @elseif($user_info->userprivil == 1)
                <li>User Level: <span style="color: silver">Silver Coder</span></li>
            @elseif($user_info->userprivil == 0)
                <li>User Level: Coder</li>
            @else
                <li>User Level: Inactivated</li>
            @endif
            <br>

            <li>Total Acceptance: <span class="badge badge-pill badge-primary">{{$user_info->userac}}</span></li>
            <li>Total Submission: <span class="badge badge-pill badge-primary">{{$user_info->usersubmission}}</span></li>
            <br>
            @if($user_info->usersubmission > 0)
                <li>Collective Acceptance Rate: <span class="badge badge-pill badge-primary">{{floor($user_info->userac/$user_info->usersubmission*100)}}%</span></li>
            @else
                <li>Collective Acceptance Rate: <span class="badge badge-pill badge-primary">N/A</span></li>
            @endif
            <br>

            @if($is_signed)
                <ul>
                    <li>Coins Balance: <span class="badge badge-pill badge-primary">{{$user_info->usercoins}}</span></li>
                    <li>Keys Balance: <span class="badge badge-pill badge-primary">{{$user_info->userkeys}}</span></li>
                </ul>
            @endif

            <h4>Recent Submission</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Submission ID</th>
                    <th scope="col">Problem ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Result</th>
                </tr>
                </thead>
                <tbody>
                @foreach($submission as $sub)
                    <tr>
                        <td>{{base64_encode($sub->sid).rand(100,999)}}</td>
                        <td><a href="{{url('/public/getsingleproblem/'.$sub->pid)}}">{{$sub->pid}}</a></td>
                        <td>{{$sub->created_at}}</td>
                        @if($sub->status == 1)
                            <td><img src="{{asset('imgs/site/correct.png')}}" alt="Accepted"></td>
                        @else
                            <td><img src="{{asset('imgs/site/wrong.png')}}" alt="Rejected"></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination justify-content-center">{{$submission->links()}}</div>
        </div>
        {{--Account--}}
        @if($is_signed)
            <hr>
            <div id="user-account">
                <h3>Account Operation</h3>
                <p>You're signed in as a member.</p>
                @if($is_signed)
                    <button class="btn btn-danger btn-lg" onclick="conf()">Sign Out</button>
                @endif
            </div>
            {{--footnote--}}
            <small>
                **We respect your privacy, other people will not be able see
                your password, email, your possessions including
                your coins, your keys, your balance
                and your account section.
            </small>
        @endif
    </div>



    <script>
        function conf() {
            if(confirm('Are you sure to sign out? Your session will be closed.'))
                location = '/protected/signout';
        }
    </script>
@endsection
