<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Codinterest Reset Password</title>
</head>
<style>
    body{
        margin: auto;
        text-align: center;
    }
    button{
        padding: 50px;
        background: dodgerblue;
        border-radius: 10px;
        margin-bottom: 50px;
        color:white;
        text-decoration: none;
        font-size: 30px;
    }
</style>
<body>
    <a href="{{url('/public/handlereset?uid='.$user->uid.'&activate=instant&reset=true&usertoken='.$user->usertoken.'&validate=true')}}">
        <button type="button" id="activation-button">Reset Password</button>
    </a> {{--Change href after setting up the website--}}
</body>
</html>
