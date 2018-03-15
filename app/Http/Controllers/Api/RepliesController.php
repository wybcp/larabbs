<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ReplyRequest;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Transformers\ReplyTransformer;

class RepliesController extends Controller
{
    public function store(ReplyRequest $request, Reply $reply, Topic $topic)
    {
        $reply->user_id = $this->user()->id;
        $reply->topic_id = $topic->id;
        $reply->content = $request->content;
        $reply->save();
        return $this->response->item($reply, new ReplyTransformer())
            ->setStatusCode(201)
            ;
    }

    public function destroy(Topic $topic, Reply $reply)
    {
        if ($topic->id !== $reply->topic_id) {
            return $this->response->errorBadRequest();
        }

        $this->authorize('destroy', $reply);
        $reply->delete();
        return $this->response->noContent();
    }

    public function index(Topic $topic)
    {
        $replies = $topic->replies()->paginate(20);
        return $this->response->paginator($replies, new ReplyTransformer());
    }

    public function userIndex(User $user, int $page_number = 20)
    {
        $replies = $user->replies()->paginate($page_number);
        return $this->response->paginator($replies, new ReplyTransformer());
    }
}
