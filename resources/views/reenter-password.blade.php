{{--Re-enter Password Page--}}
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reset Your Password</title>
        @include('styles')
        <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('styles/sign.css')}}">
        <link rel="stylesheet" href="{{asset('styles/reset-password.css')}}">
    </head>
    <style>
        /*css for only sign in page*/

    </style>
    <body>
    {{--Check if it's legally redirected--}}
    @unless(isset($user))
        <script>window.location={{url('/public/index')}}</script>
    @endunless

    <div class="sign-container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="resetForm" action="{{url('/public/finishreset')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="uid" id="uid" value="{{$user->uid}}">
            <input type="hidden" name="usertoken" id="usertoken" value="{{$user->usertoken}}">
            <h2 class="sign-header">Reset Your Password</h2>
            <br>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" required>
            </div>

            <div class="form-group">
                <label for="repassword">Confirm Password</label>
                <input type="password" class="form-control" id="repassword" name="repassword" value="{{old('repassword')}}" required minlength="6">
            </div>
            <br>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            <br>
            <small class="form-text text-muted">** We'll never share your information with other individuals or organizations.</small>
            <br>
            <p>Doesn't want to reset? <a href="{{url('/public/signin')}}">Click here</a> to sign in.</p>
        </form>
    </div>
    </body>
    @include('scripts')
    <script>
        // jQuery form validation
        $().ready(function() {
            $("#resetForm").validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6
                    },
                    repassword: {
                        required: true,
                        minlength: 6,
                        equalTo: "#password"
                    }
                }
            })
        });
    </script>
</html>
