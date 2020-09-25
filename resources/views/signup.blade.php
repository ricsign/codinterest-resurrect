{{--Sign Up Page--}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    @include('styles')
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('styles/sign.css')}}">
    <link rel="stylesheet" href="{{\Illuminate\Support\Facades\URL::asset('styles/signup.css')}}">
</head>
<body>
    {{--One user can only have one account --}}
    @unless(empty(session()->get('user')))
        <script>window.location='/public/index'</script>
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
        <form id="signupForm" action="{{url('/public/dosignup')}}" method="post">
            {{csrf_field()}}
            <h2 class="sign-header">Sign Up</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username_123" value="{{old('username')}}" required minlength="3" maxlength="20">
                <small class="form-text text-muted">Username may only use the combination English alphabets, numbers and underscore '_' with length 3~20</small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" required minlength="6">
                <small class="form-text text-muted">A strong password must have at least 6 characters</small>
            </div>
            <div class="form-group">
                <label for="repassword">Confirm Password</label>
                <input type="password" class="form-control" id="repassword" name="repassword" value="{{old('repassword')}}" required minlength="6">
                <small class="form-text text-muted">Confirm Your Password</small>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="example@123.com" value="{{old('email')}}" required minlength="4">
                <small class="form-text text-muted">A valid email that is able to receive activation link</small>
            </div>
            <div class="form-group">
                <label for="vercode">Verification Code</label>
                <input type="text" class="form-control vercode" id="vercode" name="vercode" required>
                {{--passing rand is because we want to confuse js that everytime we request a different url, preventing cache--}}
                <img src="{{url('/public/captcha/vercode')}}" class="codeimg" onclick="this.src='{{url('/public/captcha/vercode')}}'+'?rand='+Math.random()">
                <small class="form-text text-muted">To verify you as a human</small>
            </div>
            <br>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            <br>
            <small class="form-text text-muted">** We'll never share your information with other individuals or organizations.</small>
            <br>
            <p>Already have an account? <a href="{{url('/public/signin')}}">Click here</a> to sign in.</p>
        </form>
    </div>
</body>
@include('scripts')
<script>
    // jQuery form validation
    $().ready(function() {
        $("#signupForm").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    regex: "^\\w{3,20}$",
                },
                password: {
                    required: true,
                    minlength: 6
                },
                repassword: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
                vercode: {
                    required: true,
                    minlength: 6,
                    maxlength: 6
                }
            }
        })
    });
</script>
</html>
