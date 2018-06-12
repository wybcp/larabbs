<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\ReplyRequest;
use App\Models\Reply;
use App\Models\Topic;
use App\Http\Controllers\Api\Controller;
use App\Models\User;
use App\Transformers\ReplyTransformer;

class RepliesController extends Controller
{
    public function store(Topic $topic, Reply $reply, ReplyRequest $request)
    {
        $reply->content = $request->content;
        $reply->user_id = $this->user()->id;
        $reply->topic_id = $topic->id;
        $reply->save();

        return $this->response->item($reply, new ReplyTransformer())->setStatusCode(201);
    }

    public function destroy(Topic $topic, Reply $reply)
    {
        if ($reply->topic_id !== $topic->id) {
            return $this->response->errorBadRequest();
        }

        $this->authorize('destroy', $reply);
        $reply->delete();

        return $this->response->noContent();
    }

    public function index(Topic $topic)
    {
        $repies=$topic->replies()->paginate(20);

        return $this->response->paginator($repies,new ReplyTransformer());
    }

    public function userIndex(User $user)
    {
        $replies=$user->replies()->paginate(20);

        return $this->response->paginator($replies,new ReplyTransformer());
    }
}
