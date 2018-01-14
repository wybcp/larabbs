<?php

namespace App\Observers;

use App\Models\Topic;
use function makeExcerpt;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        $topic->excerpt=makeExcerpt($topic->body);
    }
}