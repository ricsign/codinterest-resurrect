{{--Blade Template For All Pages--}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Codinterest</title>
    @include('styles')
    @include('scripts')
</head>
<body>
    @include('header')
    <div class="main">
        @yield('main')
    </div>
    @include('footer')
</body>
{{--scripts deal with DOM--}}
@include('dom-root')
</html>
