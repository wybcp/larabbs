@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop
@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    @if($topic->id)
                        编辑话题 #{{$topic->id}}
                    @else
                        新建话题
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($topic->id)
                    <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="title-field">标题</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required/>
                </div>
                <div class="form-group">
                    <select class="form-control" name="category_id" required>
                        <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>请选择分类</option>
                        @foreach ($categories as $value)
                            <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" >
                	<label for="body-field">内容</label>
                	<textarea name="body" id="body-field" class="form-control" rows="3" placeholder="请填入至少三个字符的内容。" required>{{ old('body', $topic->body ) }}</textarea>
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        保存
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript"  src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/simditor.js') }}"></script>

    <script>
        $(document).ready(function(){
            var editor = new Simditor({
                textarea: $('#body-field'),
            });
        });
    </script>

@stop