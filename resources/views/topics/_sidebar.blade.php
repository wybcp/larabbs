<div class="card">
    <div class="card-body">
        <a href="{{ route('topics.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
            新建帖子
        </a>
    </div>
</div>
@php
    $user=new \App\Models\User();
    $active_users = $user->getActiveUsers();
@endphp
@if (count($active_users))
    <div class="card">
        <div class="card-body active-users">

            <div class="text-center">活跃用户</div>
            <hr>
            @foreach ($active_users as $active_user)
                <a class="media" href="{{ route('users.show', $active_user->id) }}">
                    <div class="media-left media-middle">
                        <img src="{{ $active_user->avatar }}" width="24px" height="24px" class="img-circle media-object">
                    </div>

                    <div class="media-body">
                        <span class="media-heading">{{ $active_user->name }}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@endif
@php
    $link=new \App\Models\Link();
    $links=$link->getAllCached();
@endphp
@if (count($links))
    <div class="card">
        <div class="card-body active-users">

            <div class="text-center">资源推荐</div>
            <hr>
            @foreach ($links as $i)
                <a href="{{$i->link}}" class="media">
                    <div class="media-body">
                        <span>{{$i->title}}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@endif