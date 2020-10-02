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
                <a class="nav-link" href="{{url('/public/allarticles')}}">Articles</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Explore
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{url('/public/contribute')}}">Contribute</a>
                    <a class="dropdown-item" href="{{url('/public/redeem')}}">Redeem</a>
                </div>
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
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <li class="nav-item">
                <form class="form-inline">
                    <input class="form-control mr-sm-2 input-sm" id="search-input" type="search" placeholder="Search Problem By ID" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0 btn-sm" id="search-btn" type="submit">Search</button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<script>
    // redirect based on user's input
    $("#search-btn").click(function (){
        let userInput = $("#search-input").val();
        if(!userInput || !/^[0-9]*$/.test(userInput)){
            alert('Please enter a valid Problem ID!');
            return false;
        }
        location = '/public/getsingleproblem/'+userInput;
        return false;
    });
</script>
