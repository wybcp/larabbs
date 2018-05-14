<?php

namespace App\Observers;

use App\Jobs\TranslateSlug;
use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
use function dispatch;

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
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body, 100);
// 如 slug 字段无内容，即使用翻译器对 title 进行翻译
//        if (!$topic->slug) {
////            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
//            dispatch(new TranslateSlug($topic));
//        }
    }
    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {
            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }
}