@extends("root")
@section("main")

    <link rel="stylesheet" href="{{asset('styles/getsingletalk.css')}}">
    <img id="previous" src="{{asset('imgs/site/previous.png')}}" alt="">

    @if(session()->get('success-msg'))
        <div class="alert alert-success alert-dismissible fade show">{{session()->get('success-msg')}}</div>
    @endif
    <div class="talk-container">
        <br>
        <h2>{{$talk->ttit}}</h2>
        <br>
        <div style="font-weight: bold;color: white; float:right"><h5 style=" background-color: rgb({{$talk->topic->topiccolor}}); padding: 5px 10px; border-radius: 10px">#&nbsp;{{$talk->topic->topicname}}</h5></div>
        <br><br>
        <div class="talk-content">
            {!! \App\Tools\GeneralTools::convert_markdown_to_html($talk->tcontent) !!}
        </div>
    </div>
    <br>
    {{--talk footer--}}
    <div class="talk-footer">
        <div>
            <img src="{{asset('imgs/site/views.png')}}" alt="Views: " title="Views"> &nbsp;&nbsp;&nbsp;
            <span>{{$talk->tviews}}</span>
        </div>
        <br>
        <div>
            <img src="{{asset('imgs/site/comments.png')}}" alt="Replies: " title="Replies"> &nbsp;&nbsp;&nbsp;
            <span>{{$talk->treplies}}</span>
        </div>
        <br>
        <div>
            <img src="{{asset('imgs/site/author.png')}}" alt="Author: " title="Author"> &nbsp;&nbsp;&nbsp;
            <span><a href="{{url('/public/myaccount/'.$talk->uid)}}">{{$talk->user->user->username}}</a></span>
        </div>
        <br>
        <div>
            <img src="{{asset('imgs/site/articledate.png')}}" alt="Created At: " title="Created At: "> &nbsp;&nbsp;&nbsp;
            <span>{{$talk->created_at}}</span>
        </div>
        <br>
        <div>
            <img src="{{asset('imgs/site/edit.png')}}" alt="Updated At: " title="Updated At: "> &nbsp;&nbsp;&nbsp;
            <span>{{$talk->updated_at}}</span>
        </div>
    </div>
    @if(session()->get('user') && session()->get('user')->uid == $talk->uid)
        <br>
        <div>
            <a class="btn btn-primary" href="{{url('/protected/edittalk/'.$talk->tid)}}">Edit Talk</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn btn-danger" href="">Delete Talk</a>
        </div>
    @endif
    <br><br>
    <hr>
    <br><br>


    <h3>Replies</h3>
    {{--reply section (composing)--}}
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <li class="layui-this">Reply</li>
            <li id="preview-btn">Preview HTML</li>
            <li>Markdown Syntax Reference</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @elseif (session()->get('reply-success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session()->get('reply-success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form action="{{'/protected/postreply'}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$talk->tid}}" name="tid">
                    <label for="compose-textarea">Reply (Maximum 2000 characters, Markdown is supported)</label>
                    <textarea class="form-control" id="compose-textarea" name="compose-textarea" rows="5" onkeyup="getlength();" placeholder="Please be kind, do not use abusive languages. You can @ some people by @username@ at the beginning."></textarea>
                    <small id="characters-len" style="color: red">0/2000</small>
                    <br><br>
                    <button type="submit" class="btn btn-primary">Reply</button>
                </form>
            </div>
            <div class="layui-tab-item">
                <label for="preview-textarea">Preview HTML</label>
                <textarea class="form-control" id="preview-textarea" rows="5" disabled></textarea>
            </div>
            <div class="layui-tab-item" id="markdown-syntax">
            </div>
        </div>
    </div>

    {{--replies section (displaying)--}}
    <div class="display-replies">
        @foreach($replies as $reply)
            <div>
                <img src="{{asset('imgs/site/userprivil'.$reply->user->userprivil.'.png')}}" alt="user-profile-photo" width="20px" height="20px" class="profile"> &nbsp;&nbsp;&nbsp;
                <a href="{{url('/public/myaccount/'.$reply->uid)}}"><b>{{$reply->user->user->username}}</b></a>
                <small class="level-number">
                    #{{$replies_size-(($replies ->currentpage()-1) * $replies ->perpage() + $loop->iteration)+1}}
                    @if(session()->get('user') && session()->get('user')->uid == $reply->uid)
                        &nbsp;(Me)
                    @endif
                </small>
                <div class="display-reply-content">{!! \App\Tools\GeneralTools::convert_markdown_to_html($reply->rcontent) !!}</div>
                <small class="post-time">{{$reply->created_at}}</small>
                @if(session()->get('user') && session()->get('user')->uid == $reply->uid)
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <small class="delete" onclick="deleteReply({{$reply->rid}})">Delete</small>
                @endif
            </div>
        @endforeach
        <div class="pagination justify-content-center">{{$replies->links()}}</div>
    </div>



    <script>
        // default layui load
        layui.use('element', function(){
            let element = layui.element;
        });


        // markdown render
        $(document).ready(function (){
            $('#markdown-syntax').load('{{asset('html/markdown-syntax.html')}}');
            $('#preview-btn').click(function (){
                let md = window.markdownit();
                let result = md.render($('#compose-textarea').val());
                $('#preview-textarea').html(result);
            });
        });


        // get the textarea's length
        function getlength(){
            let len = $('#compose-textarea').val().length;
            if(len <= 2000 && len >= 5){
                $('#characters-len').html('<span style="color:green">'+len+'/2000</span>');
            }
            else{
                $('#characters-len').html('<span style="color:red">'+len+'/2000</span>');
            }
        }


        // redirect to delete reply page
        function deleteReply(rid){
            if(confirm("Are you sure to delete this reply?"))
                location = "/protected/deletereply/"+rid;
        }
    </script>
@endsection
