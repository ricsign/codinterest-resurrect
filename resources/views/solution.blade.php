<div class="solution-container">
    <link rel="stylesheet" href="{{asset('styles/solution.css')}}">
    <h3>{{$problem->ptit}} Solution</h3>
    <br><br>
    <div>
        {!! $problem->psol !!}
    </div>
    @include('styles')
    @include('scripts')
    <a href="{{url('/public/getsingleproblem/'.$problem->pid)}}" class="btn btn-primary btn-lg btn-block" style="width:70%">Return To Problem</a>
    <br>
    <a href="{{url('/public/getproblems/'.$problem->pterrid)}}" class="btn btn-success btn-lg btn-block" style="width:70%">Return To Territory</a>
</div>
