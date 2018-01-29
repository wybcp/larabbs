<!doctype html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title', 'LaraBBS') - {{ setting('site_name', 'Laravel 进阶教程') }}</title>
    <meta name="description" content="@yield('description', setting('seo_description', 'LaraBBS 爱好者社区。'))" />
    <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'LaraBBS,社区,论坛,开发者论坛'))" />

    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
    @yield('styles')
    <title>Document</title>
</head>
<body>
<div id="app" class="{{getRouteClass()}}-page">
    @include('layouts._header')
    <div class="container">
        @include('layouts._message')
        @yield('content')
    </div>

    @if(app()->isLocal())
        @include('sudosu::user-selector')
    @endif

    @include('layouts._footer')
    <script src="{{mix('js/app.js')}}"></script>
    @yield('scripts')
</div>
</body>
</html>