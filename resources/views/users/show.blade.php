@extends('layouts.default')
@section('title',$user->name)

@section('content')
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <div class="col-md-12">
                <div class="offset-md-2 col-md-8">
                    <section class="user_info">
                        @include('layouts._user_gravatar',['user'=>$user])
                    </section>
                    <section class="stats">
                        @include('layouts._stats', ['user' => $user])
                    </section>
                </div>
            </div>
            <div class="col-md-12">
                @if (Auth::check())
                    @include('users._follow_form')
                @endif
                @if (count($statuses) > 0)
                    <ol class="statuses">
                        @foreach ($statuses as $status)
                            @include('statuses._status')
                        @endforeach
                    </ol>
                    {!! $statuses->render() !!}
                @endif
            </div>
        </div>
    </div>
@endsection