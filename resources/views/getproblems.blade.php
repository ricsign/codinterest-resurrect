{{--This is the main area of all problems page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/getproblems.css')}}">

    <h2 class="title">Problems In Current Territory</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Problem ID</th>
            <th scope="col">Title</th>
            <th scope="col">Reward</th>
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
                <td>{{$problem->psub}}</td>
                @if($problem->psub == 0)
                    <td>N/A</td>
                @else
                    <td>{{floor($problem->pacc/$problem->psub*100)}}%</td>
                @endif
                @if (in_array($problem->pid,$solved))
                    <td><img src="{{asset('/imgs/site/correct.png')}}" alt="AC"></td>
                @else
                    <td></td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
