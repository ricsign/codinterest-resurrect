{{--This is the main area of all problems page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/getsingleproblem.css')}}">

    {{--problem description--}}
    <div id="description-container">
        {!! $problem->pdesc !!}
    </div>

    {{--middle area--}}
    <div>
        <p>
            {{--return to the main menu--}}
            <button relocate="{{url('/public/getproblems/'.$problem->pterrid)}}" class="btn btn-secondary btn-sm" onclick="location = this.getAttribute('relocate')">
                Return To Territory
            </button>
            {{--submission tip--}}
            <button class="btn btn-info btn-sm sub-tip" type="button" data-toggle="collapse" data-target="#sub-tip-text" aria-expanded="false" aria-controls="sub-tips-text">
                Submission Tips
            </button>
        </p>
        <div class="collapse" id="sub-tip-text">
            <div class="card card-body">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is a semi-monitored submission system, which means this system will not
                judge your submission based on your code but only on your final answer. Some problems may even not require program.
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;However, in order for you to effectively improve your coding skills, you should use
                the expected algorithms and your code should meet the minimal complexity. Some problems
                are solvable with time complexity of O(2^n), but if the problem expects an O(n^3) solution,
                your program should not exceed that time complexity, but feel free to write an O(n^2logn) solution.
                Again, the submission system only judges your answer, not your actual program, but you
                should try your best to ace the problems without cheating and violation, and be self-disciplined.
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The format of submission is expected as following:
                <ol>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. If the problem has one or more inputs and one output, you should enter your answer without extra spaces or characters;</li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. If the problem has one or more inputs and multiple outputs, you should always seperate your answer with an underscore _, for example, if your answers to 5 inputs are [12,60,9,8,-1], the correct format of submission will be 12_60_9_8_-1;</li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. If the problem's answer is a boolean, please use 0 or 1 to respectively represent false or true. This is because true or false representation might vary in different languages, 0 and 1 are consistent for all languages. for example, if your answers to 4 inputs are [true,true,false,true], the correct format of submission will be 1_1_0_1;</li>
                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Your answer should only be numbers, English alphabets, underscores '_', period '.' and necessary spaces(If required).</li>
                </ol>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We wish you best luck.
            </div>
        </div>
    </div>

    {{--submission area--}}
    <div class="input-group">
        @if($is_ac)
            <img src="{{asset('/imgs/site/correct-lg.png')}}" alt="Accepted" id="ac-img">
            <h6 class="text-success">
                Your answer is accepted,
                feel free to check the solution to see one way of doing this problem.
                The solution might differ from yours.
                Only core idea will be shown, the solution trims the non-algorithmic part
                such as handling input, prompt, and etc.
            </h6>
            <a href="{{url('/protected/solution/'.$problem->pid)}}" class="btn btn-primary btn-lg btn-block submit">Check Core Solution</a>
        @else
            <div class="input-group-prepend">
                <span class="input-group-text">Your Answer</span>
            </div>
            <textarea class="form-control answer" id="answer" aria-label="With textarea" ></textarea>
            <p class="input-tip">
                *Please make sure your answer matches the desired answer format,
                if you're not sure,
                please click the submission tips to find out more details. <br>The verdict will be shown at the bottom after you click submit.<br>
                Every incorrect submission will result in <b>1</b> coin deduction. Please do not click submit multiple times.
            </p>
            <button class="btn btn-primary btn-lg btn-block submit" id="submit">
                Submit
            </button>
            {{--verdict--}}
            <div>
                <div id="verdict"></div><br>
                <div id="verdict-description"></div>
            </div>
        @endif
    </div>

    <script>
        // ajax send submission to the server
        $(document).ready(
            $("#submit").click(function () {
                $("#submit").attr('disabled','disabled'); // set the button to disabled
                $("#submit").html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>') // set spinner
                setTimeout(function () {
                    $.ajax({
                        url:"/protected/submission",
                        dataType:"json",
                        type:"POST",
                        cache:false,
                        async:false,
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "pid": {{$problem->pid}},
                            "answer":$("#answer").val()
                        },
                        success:function (data) {
                            if(data.status === -1){
                                $("#verdict").html('<h3 class="text-warning" style="margin: 50px 0 0 0">Invalid</h3>');
                                $("#verdict-description").html('<p class="text-warning">'+data.msg+'</p>');
                            }else if(data.status === 0){
                                $("#verdict").html('<h3 class="text-danger" style="margin: 50px 0 0 0">Rejected</h3>');
                                $("#verdict-description").html('<p class="text-danger">'+data.msg+'</p>');
                            }else if(data.status === 1){
                                $("#verdict").html('<h3 class="text-success" style="margin: 50px 0 0 0">Accepted</h3>');
                                $("#verdict-description").html('<p class="text-success">'+data.msg+'</p>');
                            }
                            $("#submit").removeAttr('disabled');
                            $("#submit").html('Submit');
                        },
                        error:function () {
                            $("#verdict").html('<h3 class="text-danger" style="margin: 50px 0 0 0">Error</h3>');
                            $("#verdict-description").html("<p class='text-danger'>We cannot process your submission right now, you won't be negatively affected, please try again later.</p>");
                            $("#submit").removeAttr('disabled');
                            $("#submit").html('Submit');
                        }
                    })
                },2000); // set timeout prevents user from repeatedly clicking and constantly sending ajax
            })
        )
    </script>
@endsection
