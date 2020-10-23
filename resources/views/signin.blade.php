{{--Sign Up Page--}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In</title>
    @include('styles')
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('styles/sign.css')}}">
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('styles/signin.css')}}">
</head>
<body>
    {{--One user can only have one account --}}
    @unless(empty(session()->get('user')))
        <script>window.location='/public/index'</script>
    @endunless

    <div class="sign-container">
        @unless(empty(session()->get('msg')))
            <div class="alert alert-success">{{session()->get('msg')}}</div>
        @endunless
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="signinForm" action="{{url('/public/dosignin')}}" method="post">
            {{csrf_field()}}
            <h2 class="sign-header">Sign In</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{old('username')}}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" required>
            </div>
            <div class="form-group">
                <label for="vercode">Verification Code</label>
                <input type="text" class="form-control vercode" id="vercode" name="vercode" required>
                {{--passing rand is because we want to confuse js that everytime we request a different url, preventing cache--}}
                <img class="codeimg" onclick="this.src='{{url('/public/captcha/vercode')}}'+'?rand='+Math.random()"
                     src="{{url('/public/captcha/vercode')}}" alt="Verification Code">
                <small class="form-text text-muted">To verify you as a human</small>
            </div>
            <br>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            <br>
            <small class="form-text text-muted">** We'll never share your information with other individuals or organizations.</small>
            <br>
            <p>Doesn't have an account? <a href="{{url('/public/signup')}}">Click here</a> to sign up.</p>
        </form>
    </div>
</body>
@include('scripts')
<script>
    // form validation
    $().ready(function() {
        $("#signinForm").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    regex: "^\\w{3,20}$"
                },
                password: {
                    required: true,
                    minlength: 6
                },
                vercode: {
                    required: true,
                    minlength: 6,
                    maxlength: 6
                }
            }, messages: {
                username: "Invalid username",
                password: "Invalid password",
                vercode: "Invalid verification code"
            }
        })
    });
</script>
</html>
