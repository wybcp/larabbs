<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\TopicRequest;
use App\Models\Topic;
use App\Transformers\TopicTransformer;
use App\Http\Controllers\Api\Controller;

class TopicsController extends Controller
{
    public function store(Topic $topic, TopicRequest $request)
    {
        $topic->fill($request->all());
        $topic->user_id = $this->user()->id;
        $topic->save();
        return $this->response->item($topic, new TopicTransformer())->setStatusCode(201);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $this->update($request->all());

        return $this->response->item($topic, new TopicTransformer());
    }
}
