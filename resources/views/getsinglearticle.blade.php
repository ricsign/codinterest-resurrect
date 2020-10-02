{{--This is the main area of all problems page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/getsinglearticle.css')}}">

    <img id="previous" src="{{asset('imgs/site/previous.png')}}" alt="previous">
    {{--article content--}}
    <div id="content-container">
        {!! $article->acontent !!}
    </div>

@endsection
