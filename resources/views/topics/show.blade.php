@extends('layouts.app')
@section('title', $topic->title)
@section('description', $topic->excerpt)
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">作者：{{ $topic->user->name }}</h2>
                    </div>
                    <hr>
                    <div class="card-img">
                        <div align="center">
                            <a class="card-link" href="{{ route('users.show', $topic->user->id) }}">
                                <img class="img-thumbnail" src="{{ $topic->user->avatar }}" width="300px" height="300px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">{{ $topic->title }}</h1>
                        <div class="article-meta text-center">
                            {{ $topic->created_at->diffForHumans() }}⋅ 回复：{{ $topic->reply_count }}
                        </div>
                        <div>
                            摘要：{{$topic->excerpt}}
                        </div>
                        <div class="">
                            {!! $topic->body !!}
                        </div>

                        <div class="float-right">
                            <hr>
                            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-default btn-xs" role="button">
                                编辑
                            </a>
                            <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-default btn-xs" >
                                    删除
                                </button>
                            </form>
                        </div>





                    </div>
                </div>
                {{-- 用户回复列表 --}}
                <div class="card">
                    <div class="card-body">
                        @includeWhen(Auth::check(), 'topics._reply_box', ['topic' => $topic])
                        {{--@include('topics._reply_box', ['topic' => $topic])--}}
                        @include('topics._reply_list', ['replies' => $topic->replies()->with('user')->get()])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
