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

    {{--comment section--}}


@endsection
