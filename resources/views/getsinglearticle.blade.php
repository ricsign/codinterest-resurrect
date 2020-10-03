{{--This is the main area of all problems page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/getsinglearticle.css')}}">

    <img id="previous" src="{{asset('imgs/site/previous.png')}}" alt="previous">
    {{--article content--}}
    <div id="content-container">
        {!! $article->acontent !!}
    </div>
    {{--article footer--}}
    <div class="article-footer">
        <div>
            <img src="{{asset('imgs/site/views.png')}}" alt="Views: " title="Views"> &nbsp;&nbsp;&nbsp;
            <span>{{$article->aviews}}</span>
        </div>
        <br>
        <div>
            <img src="{{asset('imgs/site/comments.png')}}" alt="Comments: " title="Comments"> &nbsp;&nbsp;&nbsp;
            <span>{{$article->acomments}}</span>
        </div>
        <br>
        <div>
            <img src="{{asset('imgs/site/author.png')}}" alt="Author: " title="Author"> &nbsp;&nbsp;&nbsp;
            @if($article->authoruid == -1)
                <span>Codinterest Official</span>
            @else
                <span><a href="{{url('/public/myaccount/'.$article->authoruid)}}">Codinterest User</a></span>
            @endif
        </div>
    </div>

    <br><br><br>
    <h3 id='compose-h3'>Comments</h3>
    <br>
    {{--comment section (composing)--}}
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <li class="layui-this">Compose Your Comment</li>
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
                @elseif (session()->get('comment-success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session()->get('comment-success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form action="{{url('/protected/postcomment')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$article->aid}}" name="aid">
                    <label for="compose-textarea">Compose Your Comment (Maximum 2000 characters, Markdown is supported)</label>
                    <textarea class="form-control" id="compose-textarea" name="compose-textarea" rows="5" onkeyup="getLength();" placeholder="Please be kind, do not use abusive languages."></textarea>
                    <small id="characters-len" style="color: red">0/2000</small>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
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
    <br><br>

    {{--comment section (displaying)--}}
    <div class="display-comments">
        @foreach($comments as $comment)
            <div>
                <img src="{{asset('imgs/site/userprivil'.$comment->user->userprivil.'.png')}}" alt="user-profile-photo" width="20px" height="20px" class="profile"> &nbsp;&nbsp;&nbsp;
                <a href="{{url('/public/myaccount/'.$comment->uid)}}"><b>{{$comment->user->user->username}}</b></a>
                <small class="level-number">#{{$comments_size-(($comments ->currentpage()-1) * $comments ->perpage() + $loop->iteration)+1}}</small>
                <div class="display-comment-content">{!! \App\Tools\GeneralTools::convert_markdown_to_html($comment->ccontent) !!}</div>
                <small class="post-time">{{$comment->created_at}}</small>
            </div>
        @endforeach
        <div class="pagination justify-content-center">{{$comments->links()}}</div>
    </div>



    {{--JS--}}
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
