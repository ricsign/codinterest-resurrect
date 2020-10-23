@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/choosetopics.css')}}">
    <h2>Choose Topics</h2>
    @if(isset($talks) && count($talks) > 0)
        <br><br>
        @foreach($selectedtopics as $topic)
            <span style="background-color: rgb({{$topic->topiccolor}}); color: white; padding: 5px; border-radius: 10px"># {{$topic->topicname}}</span>
        @endforeach
        <div><br><br></div>
        <h4>Result</h4>
        <div>
            <br>
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
            <br><br>
        </div>
    @endif

    <h4>Select From Below</h4>
    <div class="topics-tabs">
        <div class="layui-tab layui-tab-brief">
            <ul class="layui-tab-title">
                <li class="layui-this"><b>Popular</b></li>
                <li><b>Recent</b></li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show" style="width: 50%;margin: auto">
                    <ul class="list-group">
                        @foreach($populartopics as $topic)
                            <li class="list-group-item d-flex justify-content-between align-items-center" tid="{{$topic->topicid}}" onclick="addTopic(this)">
                                <span style="background-color: rgb({{$topic->topiccolor}}); color: white; padding: 5px; border-radius: 10px"># {{$topic->topicname}}</span>
                                <span class="badge badge-primary badge-pill">{{$topic->topicbelongsto}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="layui-tab-item" style="width: 50%;margin: auto">
                    <ul class="list-group">
                        @foreach($newtopics as $topic)
                            <li class="list-group-item d-flex justify-content-between align-items-center" tid="{{$topic->topicid}}" onclick="addTopic(this)">
                                <span style="background-color: rgb({{$topic->topiccolor}}); color: white; padding: 5px; border-radius: 10px"># {{$topic->topicname}}</span>
                                <span class="badge badge-primary badge-pill">{{$topic->topicbelongsto}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>


    <script>
        // default load layui
        layui.use('element', function(){
            let element = layui.element;

            //…
        });


        // redirect to add topic page
        function addTopic(obj){
            let loc = String(window.location);
            if(!isNaN(Number(loc[loc.length-1])))
                window.location += '&'+obj.getAttribute('tid');
            else if(loc[loc.length-1] === "/")
                window.location += obj.getAttribute('tid');
            else
                window.location += '/'+obj.getAttribute('tid');
        }
    </script>
@endsection
