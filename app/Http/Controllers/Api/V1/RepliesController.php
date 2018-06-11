<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\ReplyRequest;
use App\Models\Reply;
use App\Models\Topic;
use App\Http\Controllers\Api\Controller;
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
}
