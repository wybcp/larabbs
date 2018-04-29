<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" type="text/css">
    <title>@yield('title','Blog')</title>
</head>
<body>
@include('layouts._header')
<div id="container">
    <div class="offset-md-1 col-md-10">
        @include('layouts._messages')
        @yield('content')
        @include('layouts._footer')
    </div>
</div>

</body>
</html>