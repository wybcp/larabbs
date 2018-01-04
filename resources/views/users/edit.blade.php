@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-default col-md-10 col-md-offset-1">
            <div class="panel-heading">
                <h4>
                    <i class="glyphicon glyphicon-edit"></i> 编辑个人资料
                </h4>
            </div>
            @include('common.error')
            <div class="panel-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name-field">用户名</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name ) }}" placeholder="'英文、数字、横杆和下划线,3 - 25 个字符。"/>
                    </div>
                    <div class="form-group">
                        <label for="email-field">邮 箱</label>
                        <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="introduction-field">个人简介</label>
                        <textarea name="introduction" id="introduction-field" class="form-control" rows="3" placeholder="个人简介不能超过 80 个字符">{{ old('introduction', $user->introduction ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="avatar" class="avatar-label">用户头像</label>
                        <input type="file" name="avatar">
                        <p> 提示：png,jpeg, bmp, png, gif 格式的图片,宽和高需要 200px 以上。</p>
                        @if($user->avatar)
                            <br>
                            <img src="{{$user->avatar}}" alt="用户头像" class="thumbnail img-responsive" width="200">
                        @endif
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
