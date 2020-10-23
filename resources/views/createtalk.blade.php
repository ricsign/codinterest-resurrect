{{--This is the main area of index page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/createtalk.css')}}">

    @if(isset($oldttit))
        <h2 class="title">Edit Talk</h2>
    @else
        <h2 class="title">Create A New Talk</h2>
    @endif

    <br>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <br>

    <form id="createtalk-form" action="{{isset($oldtid) ? url('/protected/handleedittalk'): url('/protected/newtalk')}}" method="post">
        @csrf
        <input type="hidden" name="oldtid" value="{{isset($oldtid) ? $oldtid : -1}}">
        <div class="form-group">
            <label for="talktitle">Talk Title</label>
            <input type="text" class="form-control" id="talktitle" name="talktitle" aria-describedby="talktitle-small" placeholder="My First Talk" style="width: 40%" value="{{isset($oldttit) ? $oldttit : old('talktitle')}}">
            <small id="talktitle-small" class="form-text text-muted" style="width: 40%">Name your talk with an appropriate title with length of 5 to 50.</small>
        </div>
        <div class="form-group">
            <label for="maintopic">Main Topic</label>
            <div class="input-group mb-3" id="topic" style="width: 40%">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><b>#</b></span>
                </div>
                <input type="text" class="form-control" id="maintopic" name="maintopic" aria-label="maintopic" aria-describedby="topic-small" value="{{isset($oldtopicname)? $oldtopicname: old('maintopic')}}">
                <small id="topic-small" class="form-text text-muted">Length 2 to 20. If no one used your topic entered, we will create a new one for you.</small>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="content">Content(Markdown Supported)</label>
                    <textarea class="form-control" id="content" name="content" rows="15" onkeyup="getlength();">{{isset($oldtcontent)? $oldtcontent: old('content')}}</textarea>
                    <small id="characters-len" style="color: red">0/20000</small>
                </div>
                <div class="col">
                    <label for="preview">Preview HTML</label>
                    <textarea class="form-control" id="preview" rows="15" DISABLED></textarea>
                </div>
            </div>

        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="confirmation" onclick="toggleSubmit()">
            <label class="form-check-label" for="confirmation">Yes, I am sure to share my talk!</label>
        </div>

        {{--MarkDown References--}}
        <button class="btn btn-success md-ref" type="button" data-toggle="collapse" data-target="#md-ref" aria-expanded="false" aria-controls="md-ref">
            MarkDown References
        </button>

        <button id="post-talk" type="submit" class="btn btn-primary" disabled="disabled">Submit</button>
    </form>

    <div class="collapse" id="md-ref">
        <div class="card card-body">

        </div>
    </div>


    <script>
        $(document).ready(function (){
            // load md syntax file
            $('#md-ref').load('{{asset('html/markdown-syntax.html')}}');

            // convert markdown to html
            $("#content").keyup(function (e){
                let md = window.markdownit();
                let result = md.render($("#content").val());
                $("#preview").html(result);
                $("#preview")[0].style.height = $("#preview").height+100+"px";
            });

            // validate data
            $("#createtalk-form").validate({
                rules: {
                    talktitle: {
                        required: true,
                        minlength: 5,
                        maxlength: 50,
                        regex: "^[A-Za-z0-9\\s]{5,50}$"
                    },
                    maintopic:{
                        required: true,
                        minlength: 2,
                        maxlength: 20,
                        regex: "^\\w{2,30}$"
                    },
                    content:{
                        required: true,
                        minlength: 20,
                        maxlength: 20000
                    }
                }
            });
        });

        // toggle disability of submit button
        function toggleSubmit(){
            if(!$("#confirmation").attr('checked') && !$("#post-talk").attr('disabled'))
                $("#post-talk").attr('disabled',true);
            else
                $("#post-talk").attr('disabled',false);
        }


        // remind user the length
        function getlength(){
            let len = $('#content').val().length;
            if(len <= 20000 && len >= 20){
                $('#characters-len').html('<span style="color:green">'+len+'/20000</span>');
            }
            else{
                $('#characters-len').html('<span style="color:red">'+len+'/20000</span>');
            }
        }


        // prevent from leaving the page
        window.onbeforeunload = function() {

        };
    </script>
@endsection
