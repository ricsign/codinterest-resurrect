@extends("root")
@section("main")

    <link rel="stylesheet" href="{{asset('styles/talks.css')}}">
    <h2>Codinterest Talks</h2>

    <br><br>
    <div class="card search-container">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h4 style="margin-top: 25px"><b>Search A Topic</b></h4>
                    <p style="color: wheat">Search up for articles that are related to a topic.</p>
                </div>
                <div class="col">
                    <div class="input-group mb-3 input-group-lg">
                        <div class="input-group-prepend" style="margin-top: 30px">
                            <span class="input-group-text">#</span>
                        </div>
                        <input class="form-control align-items-center" style="margin-top: 30px" id="search-input" type="search" placeholder="Type Something..." aria-label="Search">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <div class="card post-container">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h4 style="margin-top: 20px"><b>Post Your Talk</b></h4>
                    <p style="color: wheat">Share the beauty of this moment.</p>
                </div>
                <div class="col">
                    <a href="{{url('/protected/createtalk')}}" class="btn btn-lg btn-outline-light" style="margin: 30px">Let's Talk!</a>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <div class="content-container">
        <div class="layui-tab layui-tab-brief">
            <ul class="layui-tab-title">
                <li class="layui-this"><b>Popular</b></li>
                <li><b>Recent</b></li>
                <li><b>Most Replies</b></li>
                <li><b>Latest Update</b></li>
                <li><b>Search Result</b></li>
            </ul>
            <div class="layui-tab-content">
                @foreach(array($talksPopular,$talksRecent,$talksMostReplies,$talksLatestUpdate) as $talks)
                    {{--The first element, namely $talkPopular will show--}}
                    @if($loop->iteration == 1)
                        <div class="layui-tab-item layui-show">
                    @else
                        <div class="layui-tab-item">
                    @endif
                        {{--Individuals--}}
                        @foreach($talks as $talk)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2 col-md-1 d-flex align-items-center">
                                            <img src="{{asset('imgs/site/userprivil'.$talk->user->userprivil.'.png')}}" height="32px" width="32px" alt="">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <a href="javascript:void(0);">
                                                <h5 style="color: #0779e4; font-weight: bold">{{$talk->ttit}}</h5>
                                            </a>
                                            <small style="color: darkgray">By
                                                <a href="{{url('/public/myaccount/'.$talk->uid)}}" style="color: #4F4F4F; font-weight: bold">
                                                    {{$talk->user->user->username}}
                                                </a>
                                            </small>
                                        </div>
                                        <div class="col-5 col-md-2 d-flex align-items-center" style="font-weight: bold;color: #4F4F4F"><h5>#&nbsp;{{$talk->topic->topicname}}</h5></div>
                                        <div class="col-5 col-md-3 d-flex align-items-center">
                                            <div class="row">
                                                <div class="col">
                                                    <b style="color: #111d5e;font-size: 18px">
                                                        {{$talk->tviews}}
                                                    </b>
                                                </div>
                                                <div class="col" style="color: darkgray">
                                                    <small>Views</small>
                                                </div>
                                                <div class="w-100"></div>
                                                <div class="col">
                                                    <b style="color: #111d5e;font-size: 18px">
                                                        {{$talk->treplies}}
                                                    </b>
                                                </div>
                                                <div class="col" style="color: darkgray">
                                                    <small>Replies</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{--end of individuals--}}
                    </div>
                @endforeach

                {{--Search Result--}}
                <div class="layui-tab-item"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function (){
            // sending ajax to server if search bar is typed
            $("#search-input").keyup(function (e){

            });


        })

    </script>
@endsection
