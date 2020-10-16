@extends("root")
@section("main")

    <link rel="stylesheet" href="{{asset('styles/getsingletalk.css')}}">
    <img id="previous" src="{{asset('imgs/site/previous.png')}}" alt="">

    <div class="talk-container">
        <br>
        <h2>{{$talk->ttit}}</h2>
        <br><br>
        <div class="talk-content">
            {!! \App\Tools\GeneralTools::convert_markdown_to_html($talk->tcontent) !!}
        </div>
    </div>




    <script>
    </script>
@endsection
