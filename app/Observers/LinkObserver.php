<?php
/**
 * Created by PhpStorm.
 * User: riverside
 * Date: 2018/2/3
 * Time: 19:57
 */

namespace App\Observers;
use App\Models\Link;
use Cache;

class LinkObserver
{
    // 在保持时清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}