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

    <img id="previous" src="{{asset('imgs/site/previous.png')}}" alt="previous" title="Return to the last page visited">
    {{--Main Block--}}
    <div class="main-block">
        <h2>User Profile</h2>
        {{--User Basic Information--}}
        <div id="user-sign">
            <h3>Basic Information</h3>
            <div><img src="{{asset('imgs/site/userprivil'.$user_info->userprivil.'.png')}}" alt=""></div>
            <ul>
                <li>User ID: <span class="badge badge-pill badge-success">{{$user->uid}}</span></li>
                <li>Username: <span class="badge badge-pill badge-success">{{$user->username}}</span></li>
                <li>Account Created At: <span class="badge badge-pill badge-success">{{$user->created_at}}</span></li>
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
                <br>
            @endif
            <h4>Recent Submission</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Submission ID</th>
                    <th scope="col">Problem ID</th>
                    <th scope="col">UTC Date</th>
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
            <br>

            <h4>Recent Comments</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Article</th>
                    <th scope="col">Content(MarkDown Syntax)</th>
                    <th scope="col">Post Time</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td><a href="{{url('/public/getsinglearticle/'.$comment->aid)}}">{{$comment->article->atit}}</a></td>
                        @if(mb_strlen($comment->ccontent) <= 80)
                            <td>{{$comment->ccontent}}</td>
                        @else
                            <td>{{mb_substr($comment->ccontent,0,80)}} ...</td>
                        @endif
                        <td>{{$comment->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{--Account--}}
        @if($is_signed)
            <hr>
            <div id="user-account">
                <h3>Account Operation</h3>
                <p>You're signed in as a member.</p>
                @if($is_signed)
                    <button class="btn btn-success btn-lg" onclick="resetpassword()">Reset My Password</button><br><br>
                    <button class="btn btn-danger btn-lg" onclick="conf()">Sign Out</button>
                @endif
            </div>
            <div id="reset-msg">

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
        @if($is_signed)
            function conf() {
                if(confirm('Are you sure to sign out? Your session will be closed.'))
                    location = '/protected/signout';
            }


            function resetpassword(){
                $.ajax({
                    url:"/public/resetpassword",
                    type:"GET",
                    dataType:"json",
                    cache:false,
                    async:false,
                    data:{
                        'uid':{{$user->uid}}
                    },
                    success: function (data){
                        if(data.status === -1){
                            $("#reset-msg").html(
                                "<h5 class=\"text-danger\" style=\"margin: 50px 0 0 0\">" +
                                data.msg +
                                "</h5>");
                        }else{
                            $("#reset-msg").html("<h5 class=\"text-success\" style=\"margin: 50px 0 0 0\">" +
                            data.msg +
                            "</h5>");
                        }
                    },
                    error: function (){
                        $("#reset-msg").html("" +
                            "<h5 class=\"text-danger\" style=\"margin: 50px 0 0 0\">" +
                            "Sorry, we could not process your request right now, please try again later!" +
                            "</h5>");
                    }
                });
            }
        @endif
    </script>
@endsection
