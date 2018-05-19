@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3  user-info">
            <div class="card">
                <div class="card-body">
                    <div align="center">
                        <img class="img-thumbnail embed-responsive" src="{{$user->avatar}}"
                             width="300px" height="300px">
                    </div>
                    <div class="media-body">
                        <hr>
                        <h4><strong>个人简介</strong></h4>
                        <p>{{$user->introduction}}</p>
                        <hr>
                        <h4><strong>注册于</strong></h4>
                        <p>{{$user->created_at->diffForHumans()}}</p>
                        <hr>
                        <h4><strong>最后活跃于</strong></h4>
                        <p>{{$user->last_actived_at->diffForHumans()}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="panel-title pull-left" style="font-size:30px;">{{ $user->name }}>
                        <small>{{ $user->email }}</small>
                    </h1>
                </div>
            </div>
            <hr>

            {{-- 用户发布的内容 --}}
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="{{ active_class(if_query('tab', null)) }} nav-item"><a class="nav-link" href="{{ route('users.show', $user->id) }}">Ta 的话题</a></li>
                        <li class="nav-item {{ active_class(if_query('tab', 'replies')) }}"><a class="nav-link" href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">Ta
                                的回复</a></li>
                    </ul>
                    @if (if_query('tab', 'replies'))
                        @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
                    @else
                        @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])

                    @endif
                </div>
            </div>

        </div>
    </div>
@stop