<form action="{{route('statuses.store')}}" method="post">
    @include('layouts._errors')
    @csrf
    <textarea class="form-control" rows="3" placeholder="聊聊新鲜事儿..." name="content">
        {{ old('content') }}
    </textarea>
    <button type="submit" class="btn btn-primary pull-right">发布</button>
</form>