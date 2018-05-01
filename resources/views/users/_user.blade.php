<li>
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar"/>
    <a href="{{ route('users.show', $user->id) }}" class="username">{{ $user->name }}</a>
    @can('destroy',$user)
        <form action="{{route('users.destroy',$user->id)}}" method="post">
            @csrf
            {{method_field('DELETE')}}
            <button class="btn btn-danger btn-sm delete-btn">删除</button>
        </form>
    @endcan
</li>