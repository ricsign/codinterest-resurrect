{{--This is the main area of all problems page, extending the root template--}}
@extends('root')
@section('main')
    @php
        $terridtoname = array(1 => 'Plain', 2 => 'River', 3 => 'Mountain', 4 => 'Desert', 5 => 'Plateau', 6 => 'Ocean');
    @endphp
    <link rel="stylesheet" href="{{asset('styles/allproblems.css')}}">

    <h2>Problem Set</h2>

    {{--classified problems area--}}
    <div class="card-deck card-deck-1">
        <div class="card">
            <img class="card-img-top" src="{{asset('imgs/site/terr1.jpg')}}" alt="Plain Picture" height="43%">
            <div class="card-body">
                <h5 class="card-title">Plain</h5>
                <h6 class="card-subtitle mb-2 text-muted">Territory 1</h6>
                <p class="card-text">Fundamentals. This is where dream starts. This territory encompasses basic
                    conditionals & loops and other fundamental computer science ideas.</p>
                <a href="{{url('/public/getproblems/1')}}" class="btn btn-primary">Explore Plain</a>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="{{asset('imgs/site/terr2.jpg')}}" alt="River Picture" height="43%">
            <div class="card-body">
                <h5 class="card-title">River</h5>
                <h6 class="card-subtitle mb-2 text-muted">Territory 2</h6>
                <p class="card-text">Hash Table, Sorting & Searching. This territory includes some important techniques
                    may be used in daily life & competitive programming. </p>
                <a href="{{url('/public/getproblems/2')}}" class="btn btn-primary">Explore River</a>
            </div>
        </div>
    </div>

    <div class="card-deck card-deck-2">
        <div class="card">
            <img class="card-img-top" src="{{asset('imgs/site/terr3.jpg')}}" alt="Mountain Picture" height="43%">
            <div class="card-body">
                <h5 class="card-title">Mountain</h5>
                <h6 class="card-subtitle mb-2 text-muted">Territory 3</h6>
                <p class="card-text">Tree & Graph. This territory is a mountain that every programmer must conquer, it's
                    essential, techniques such as recursion, traversal and Objected-Oriented Programming may be
                    used.</p>
                <a href="{{url('/public/getproblems/3')}}" class="btn btn-primary">Explore Mountain</a>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="{{asset('imgs/site/terr4.jpg')}}" alt="Desert Picture" height="43%">
            <div class="card-body">
                <h5 class="card-title">Desert</h5>
                <h6 class="card-subtitle mb-2 text-muted">Territory 4</h6>
                <p class="card-text">Dynamic Programming, Memoization and Greedy. This territory is full of danger. You
                    might realize how inefficient naive recursion is, dynamic programming is a crucial technique to
                    reduce the time complexity, while greedy algorithm allows you to find the best solution quickly.</p>
                <a href="{{url('/public/getproblems/4')}}" class="btn btn-primary">Explore Desert</a>
            </div>
        </div>

    </div>

    <div class="card-deck card-deck-3">
        <div class="card">
            <img class="card-img-top" src="{{asset('imgs/site/terr5.jpg')}}" alt="Plateau Picture" height="43%">
            <div class="card-body">
                <h5 class="card-title">Plateau</h5>
                <h6 class="card-subtitle mb-2 text-muted">Territory 5</h6>
                <p class="card-text">Mathematics. Math and Computer Sciences are intertwined, a great computer scientist
                    shall master mathematics. <br><span style="color: red">In this territory, you will not need programming to solve the problems.</span>
                </p>
                <a href="{{url('/public/getproblems/5')}}" class="btn btn-primary">Explore Plateau</a>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="{{asset('imgs/site/terr6.jpg')}}" alt="Ocean Picture" height="43%">
            <div class="card-body">
                <h5 class="card-title">Ocean</h5>
                <h6 class="card-subtitle mb-2 text-muted">Territory 6</h6>
                <p class="card-text">Extensive Topics. This is the territory where extensive topics are introduced. Some
                    examples to that are: Euler's path, basic artificial intelligence, advanced data structures such as
                    Union-Find, Trie and etc.</p>
                <a href="{{url('/public/getproblems/6')}}" class="btn btn-primary">Explore Ocean</a>
            </div>
        </div>
    </div>

    <br>
    <hr>

    {{--all problems area--}}
    <div class="allproblems-area">
        <h3 class="title">All Problems</h3>

        {{--attempted & rejected progress--}}
        <a redirect="{{url('/public/getsingleproblem/')}}" onclick="jumptoproblem(this)"  class="btn btn-primary">Random Problem</a>
        <br><br>
        <div class="progress">
            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"
                 title="Solved {{count($solved)}}" style="width: {{count($solved)/count($problems)*100}}%"
                 aria-valuenow="{{count($solved)/count($problems)*100}}" aria-valuemin="0" aria-valuemax="100">
                <b>{{count($solved)}}</b>
            </div>
            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar"
                 title="Rejected {{count($attempted)-count($solved)}}"
                 style="width: {{(count($attempted)-count($solved))/count($problems)*100}}%"
                 aria-valuenow="{{(count($attempted)-count($solved))/count($problems)*100}}" aria-valuemin="0"
                 aria-valuemax="100">
                <b>{{count($attempted)-count($solved)}}</b>
            </div>
            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar"
                 title="Unexplored {{count($problems)-count($attempted)}}"
                 style="width: {{(count($problems)-count($attempted))/count($problems)*100}}%"
                 aria-valuenow="{{(count($problems)-count($attempted))/count($problems)*100}}" aria-valuemin="0"
                 aria-valuemax="100">
                <b>{{count($problems)-count($attempted)}}</b>
            </div>
        </div>

        {{--problems table--}}
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Problem ID</th>
                <th scope="col">Title</th>
                <th scope="col">Reward</th>
                <th scope="col">Territory</th>
                <th scope="col">Total Submission</th>
                <th scope="col">Acceptance Rate</th>
                <th scope="col">AC</th>
            </tr>
            </thead>
            <tbody>
            @foreach($problems as $problem)
                <tr>
                    <th scope="row">{{$problem->pid}}</th>
                    <td><a href="{{url('/public/getsingleproblem/'.$problem->pid)}}">{{$problem->ptit}}</a></td>
                    <td>{{$problem->preward}}</td>
                    <td>{{$terridtoname[$problem->pterrid]}}</td>
                    <td>{{$problem->psub}}</td>
                    @if($problem->psub == 0)
                        <td>N/A</td>
                    @else
                        <td>{{floor($problem->pacc/$problem->psub*100)}}%</td>
                    @endif

                    @if (in_array($problem->pid,$solved))
                        <td><img src="{{asset('/imgs/site/correct.png')}}" alt="AC"></td>
                    @elseif(in_array($problem->pid,$attempted))
                        <td><img src="{{asset('/imgs/site/wrong.png')}}" alt="AT"></td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        // jump to a random problem
        function jumptoproblem(obj){
            location = obj.getAttribute('redirect') + "/" + (Math.floor(Math.random() * {{count($problems)}}) + 1);
        }
    </script>
@endsection
