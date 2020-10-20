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
                    <p style="color: wheat">Search up for articles that are related to a topic. The result will be shown below.</p>
                </div>
                <div class="col">
                    <div class="input-group mb-3 input-group-lg">
                        <div class="input-group-prepend" style="margin-top: 30px">
                            <span class="input-group-text">#</span>
                        </div>
                        <input class="form-control align-items-center" style="margin-top: 30px" id="topic-search" name="topic-search" type="search" placeholder="Type Something..." aria-label="Search">
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
                <li class="tab-titles layui-this"><b>Popular</b></li>
                <li class="tab-titles"><b>Recent</b></li>
                <li class="tab-titles"><b>Most Replies</b></li>
                <li class="tab-titles"><b>Latest Update</b></li>
                <li class="tab-titles search-title"><b>Search Result</b></li>
            </ul>
        </div>
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
                                        <div class="col-11 col-md-5">
                                            <a href="{{url('/public/getsingletalk/'.$talk->tid)}}">
                                                <h5 style="color: #0779e4; font-weight: bold">
                                                    @if(mb_strlen($talk->ttit) > 30)
                                                        {{mb_substr($talk->ttit,0,30)}}...
                                                    @else
                                                        {{$talk->ttit}}
                                                    @endif
                                                </h5>
                                            </a>
                                            <small style="color: darkgray">By
                                                <a href="{{url('/public/myaccount/'.$talk->uid)}}" style="color: #4F4F4F; font-weight: bold">
                                                    {{$talk->user->user->username}}
                                                </a>
                                            </small>
                                        </div>
                                        <div class="col-6 col-md-3 d-flex align-items-center" style="font-weight: bold;color: white;">
                                            <h6 style=" background-color: rgb({{$talk->topic->topiccolor}}); padding: 5px 10px; border-radius: 10px">
                                                #&nbsp;{{$talk->topic->topicname}}
                                            </h6>
                                        </div>
                                        <div class="col-5 col-md-3 d-flex align-items-center">
                                            <div class="row">
                                                <div class="col">
                                                    <b style="color: #111d5e;font-size: 18px">
                                                        {{$talk->tviews}} &nbsp;&nbsp;&nbsp;
                                                    </b>
                                                    <small>Views</small>
                                                </div>
                                                <div class="w-100"></div>
                                                <div class="col">
                                                    <b style="color: #111d5e;font-size: 18px">
                                                        {{$talk->treplies}} &nbsp;&nbsp;&nbsp;
                                                    </b>
                                                    <small>Replies</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{--end of individuals--}}
                        <br>
                        <div class="pagination justify-content-center">{{$talks->links()}}</div>
                    </div>
                @endforeach

                {{--Search Result--}}
                <div class="layui-tab-item search-res-tab">
                    <h3 style="margin-top: 50px;color: #7F7F7F;text-align: center" id="topic-msg-box">
                        No Result
                    </h3>
                </div>
            </div>
        </div>

    <br>
    <div class="card topics-container">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h4 style="margin-top: 25px"><b>Choose Some Topics</b></h4>
                    <p style="color: wheat">Not satisfying with the result? Go and select some certain topics you need</p>
                </div>
                <div class="col">
                    <a href="{{url('/public/choosetopics')}}" class="btn btn-lg btn-outline-light" style="margin: 40px">Choose My Topics</a>
                </div>
            </div>
        </div>
    </div>


    <script>
        layui.use('element', function(){
            let element = layui.element;

            //…
        });

        $(document).ready(function (){
            // sending ajax to server if search bar is typed
            $("#topic-search").keyup(function (){
                // 1. get input and validate
                let userInput = $('#topic-search').val();
                // 2. send ajax to the server, receive msg, change `search result` tab
                $.ajax({
                    url: "{{url('/public/topicsearchresult')}}",
                    dataType: 'json',
                    type:"GET",
                    cache:false,
                    async:false,
                    data: {
                        "userInput": userInput,
                    },
                    success:function (data){
                        $('.layui-tab-item').removeClass('layui-show');
                        $('.search-res-tab').addClass('layui-show');
                        $('.tab-titles').removeClass('layui-this');
                        $('.search-title').addClass('layui-this');

                        if(data.status === -1){
                            $('#topic-msg-box').html(data.data);
                        } else{
                            $('.search-res-tab').html(data.data);
                        }
                    },
                    error: function (){
                        $('#topic-msg-box').text('ಠ_ಠ An Error Just Occurred');
                    }
                });
            });
        })
    </script>
@endsection
