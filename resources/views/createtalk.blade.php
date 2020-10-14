{{--This is the main area of index page, extending the root template--}}
@extends('root')
@section('main')
    <link rel="stylesheet" href="{{asset('styles/createtalk.css')}}">

    <h2 class="title">Create A New Talk</h2>
    <br><br>

    <form id="createtalk-form">
        <div class="form-group">
            <label for="talktitle">Talk Title</label>
            <input type="text" class="form-control" id="talktitle" name="talktitle" aria-describedby="talktitle-small" placeholder="My First Talk" style="width: 40%" >
            <small id="talktitle-small" class="form-text text-muted" style="width: 40%">Name your talk with an appropriate title with length of 5 to 50.</small>
        </div>
        <div class="form-group">
            <label for="maintopic">Main Topic</label>
            <div class="input-group mb-3" id="topic" style="width: 40%">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><b>#</b></span>
                </div>
                <input type="text" class="form-control" id="maintopic" name="maintopic" aria-label="maintopic" aria-describedby="topic-small">
                <small id="topic-small" class="form-text text-muted">Length 2 to 30. If no one used your topic entered, we will create a new one for you.</small>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="content">Content(Markdown Supported)</label>
                    <textarea class="form-control" id="content" name="content" rows="15"></textarea>
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
        <button id="post-talk" type="submit" class="btn btn-primary" disabled="disabled">Submit</button>
    </form>



    <script>
        $(document).ready(function (){
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
                        regex: "^\\w{5,50}$"
                    },
                    maintopic:{
                        required: true,
                        minlength: 2,
                        maxlength: 30,
                        regex: "^\\w{2,30}$"
                    },
                    content:{
                        required: true,
                        minlength: 20,
                        maxlength: 50000
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
    </script>
@endsection
