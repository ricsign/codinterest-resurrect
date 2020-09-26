{{--Common Header File--}}
<link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('styles/header.css')}}">
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="{{url('/public/index')}}">Codinterest</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/public/index')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/public/allproblems')}}">Problems</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/public/ranking')}}">Ranking</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/public/redeem')}}">Redeem</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Resources</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                @if(empty(session()->get('user')))
                    <a class="nav-link" href="{{url('/public/signup')}}">Sign Up</a>
                @else
                    <a class="nav-link" href="{{url('/public/myaccount/'.session()->get('user')->uid)}}">My Account</a>
                @endif
            </li>
        </ul>
    </div>
</nav>
