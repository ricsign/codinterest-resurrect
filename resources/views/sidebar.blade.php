<link rel="stylesheet" href="{{asset('styles/sidebar.css')}}">

@php
    use App\Http\Controllers\ArticlesController;use App\Http\Controllers\InfoController;use App\Http\Controllers\ProblemsController;$problems = ProblemsController::allproblemsFromView();
    $articles = ArticlesController::allarticlesFromView();
    $user = false;
    if(session()->get('user'))
        $user = InfoController::getUserInfoFromView(session()->get('user')->uid)
@endphp

<ul id="sidebar" class="layui-nav layui-nav-tree layui-bg-cyan layui-inline show-sidebar" lay-filter="sidebar"
    title="Click the brand, empty space on the left of the screen or simply 'Menu' to toggle sidebar">
    @if($user)
        <li>
            <img src="{{asset('imgs/site/userprivil'.$user->userprivil.'.png')}}" alt=""
                 class="rounded mx-auto d-block">
        </li>
        <li>
            <br>
            <a href="{{url('/public/myaccount/'.session()->get('user')->uid)}}" class="d-flex justify-content-center"
               style="font-size: 20px;color: white">My Account</a>
            <br>
            <hr>
            <br>
        </li>
    @endif
    <li class="menu" onclick="toggleSideBar()">
        Menu
    </li>
    <li class="layui-nav-item"><a href="{{url('/public/index')}}">Home</a></li>
    <li class="layui-nav-item">
        <a href="javascript:">Problems</a>
        <dl class="layui-nav-child">
            @foreach($problems as $problem)
                <dd><a href="{{url('/public/getsingleproblem/'.$problem->pid)}}">{{$problem->ptit}}</a></dd>
            @endforeach
        </dl>
    </li>
    <li class="layui-nav-item">
        <a href="javascript:">Articles</a>
        <dl class="layui-nav-child">
            @foreach($articles as $article)
                <dd><a href="{{url('/public/getsinglearticle/'.$article->aid)}}">{{$article->atit}}</a></dd>
            @endforeach
        </dl>
    </li>
    <li class="layui-nav-item">
        <a href="javascript:">Talks</a>
        <dl class="layui-nav-child">
            <dd><a href="{{url('/public/talks')}}">All Talks</a></dd>
            <dd><a href="{{url('/public/choosetopics')}}">Topic Searcher</a></dd>
        </dl>
    </li>
    <li class="layui-nav-item"><a href="{{url('/public/ranking')}}">Ranking</a></li>
    <li class="layui-nav-item">
        <a href="javascript:">Explore</a>
        <dl class="layui-nav-child">
            <dd><a href="{{url('/public/contribute')}}">Contribute</a></dd>
            <dd><a href="{{url('/public/redeem')}}">Redeem</a></dd>
            <dd><a href="{{url('/public/playground')}}" target="_blank">Playground</a></dd>
            <dd><a href="{{url('https://wmcicompsci.ca/')}}">WMCI CS</a></dd>
            <dd><a href="{{url('https://laravel.com/')}}">Laravel</a></dd>
            <dd><a href="{{url('https://www.cemc.uwaterloo.ca/')}}">Waterloo CEMC</a></dd>
            <dd><a href="{{url('https://leetcode.com/')}}">LeetCode</a></dd>
        </dl>
    </li>
</ul>


{{--sidebar JS--}}
<script>
    // default layui load
    layui.use('element', function () {
        let element = layui.element;

        element.on('nav(sidebar)', function (elem) {
            layer.msg(elem.text());
        });
    });
</script>
