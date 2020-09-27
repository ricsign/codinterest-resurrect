<link rel="stylesheet" href="{{asset('styles/solution.css')}}">
<h3>{{$problem->ptit}} Solution</h3>
<h6>Modern C++ Solution</h6>
<div>
    {!! $problem->psol !!}
</div>
@include('styles')
@include('scripts')
<a href="{{url('/public/getproblems/'.$problem->pterrid)}}" class="btn btn-primary btn-lg btn-block" style="width:70%">Return To Territory</a>

