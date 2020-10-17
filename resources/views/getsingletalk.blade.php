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
        <div style="font-weight: bold;color: #4F4F4F; float:right"><h5>#&nbsp;{{$talk->topic->topicname}}</h5></div>
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
                <form action="" method="post">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$talk->tid}}" name="tid">
                    <label for="compose-textarea">Reply (Maximum 2000 characters, Markdown is supported)</label>
                    <textarea class="form-control" id="compose-textarea" name="compose-textarea" rows="5" onkeyup="getLength();" placeholder="Please be kind, do not use abusive languages. You can @ some people by @username@ at the beginning."></textarea>
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





    <script>
        layui.use('element', function(){
            let element = layui.element;
        });

        $(document).ready(function (){
            $('#markdown-syntax').load('{{asset('html/markdown-syntax.html')}}');
            $('#preview-btn').click(function (){
                let md = window.markdownit();
                let result = md.render($('#compose-textarea').val());
                $('#preview-textarea').html(result);
            });
        });

        function getLength(){
            let len = $('#compose-textarea').val().length;
            if(len <= 2000 && len >= 5){
                $('#characters-len').html('<span style="color:green">'+len+'/2000</span>');
            }
            else{
                $('#characters-len').html('<span style="color:red">'+len+'/2000</span>');
            }
        }
    </script>
@endsection
