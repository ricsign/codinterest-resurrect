<link rel="stylesheet" href="{{asset('styles/sidebar.css')}}">
@php
    $problems = \App\Http\Controllers\ProblemsController::allproblemsFromView();
    $articles = \App\Http\Controllers\ArticlesController::allarticlesFromView();
@endphp
<ul id="sidebar" class="layui-nav layui-nav-tree layui-bg-cyan layui-inline hide" lay-filter="sidebar">
    <li class="menu">
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
    <li class="layui-nav-item"><a href="{{url('/public/ranking')}}">Ranking</a></li>
    <li class="layui-nav-item">
        <a href="javascript:">Explore</a>
        <dl class="layui-nav-child">
            <dd><a href="{{url('/public/contribute')}}">Contribute</a></dd>
            <dd><a href="{{url('/public/redeem')}}">Redeem</a></dd>
            <dd><a href="{{url('https://wmcicompsci.ca/')}}">WMCI CS</a></dd>
            <dd><a href="{{url('https://laravel.com/')}}">Laravel</a></dd>
            <dd><a href="{{url('https://www.cemc.uwaterloo.ca/')}}">Waterloo CEMC</a></dd>
            <dd><a href="{{url('https://leetcode.com/')}}">LeetCode</a></dd>
        </dl>
    </li>
</ul>


<script>
    layui.use('element', function(){
        let element = layui.element;

        element.on('nav(sidebar)', function(elem){
            layer.msg(elem.text());
        });
    });
</script>
