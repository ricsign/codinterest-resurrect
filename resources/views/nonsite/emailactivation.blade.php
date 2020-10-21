<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Codinterest Account Activation</title>
    <style>
        body{
            width: 70%;
            text-align: center;
            margin: 60px auto 60px auto;
            font-family: Pacifico, serif;
            font-size: 20px;
        }
        hr{
            border-top: 5px dotted blue;
            margin: 40px 0 40px 0;
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
        #main-container{
            padding: 30px;
            border: 5px dashed black;
        }
        #username{
            color: orange;
        }
    </style>
</head>
<body>
    <div id="main-container">
        <p>
            Dear <span id="username">{{$user->username??''}}</span>, you have successfully signed up as a member,
            Please click the button below to complete your activation process before signing in.
            We appreciate your support!
        </p>
        <hr>
        <a href="{{url('/public/emailactivation?uid='.$user->uid.'&activate=instant_activation&usertoken='.$user->usertoken.'&validate=true')}}">

            <button type="button" id="activation-button">Activate</button>
        </a> {{--Change href after setting up the website--}}
    </div>
</body>
</html>
