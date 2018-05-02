@extends('layouts.default')
@section('title','Home')
@section('content')
    @guest
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p class="lead">
            你现在所看到的是 <a href="https://laravel-china.org/courses/laravel-essential-training-5.1">Laravel 入门教程</a>
            的示例项目主页。
        </p>
        <p>
            一切，将从这里开始。
        </p>
        <p>
            <a class="btn btn-lg btn-success" href="{{ route('users.create') }}" role="button">现在注册</a>
        </p>
    </div>
    @else
        <div class="row">
            <div class="col-md-8">
                <section class="status_form">
                    @include('layouts._status_form')
                </section>
                <h3>微博列表</h3>
                @include('layouts._feed')
            </div>
            <aside class="col-md-4">
                <section class="user_info">
                    @include('layouts._user_gravatar', ['user' => Auth::user()])
                </section>
                <section class="stats">
                    @include('layouts._stats', ['user' => Auth::user()])
                </section>
            </aside>
        </div>
    @endguest
@endsection