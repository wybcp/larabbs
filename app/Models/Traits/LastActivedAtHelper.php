<?php
/**
 * Created by PhpStorm.
 * User: riverside
 * Date: 2018/5/18
 * Time: 16:25
 */

namespace App\Models\Traits;

use Carbon\Carbon;
use function dd;
use Redis;
use function str_replace;

trait LastActivedAtHelper
{

    // 缓存相关配置

    protected $cache_prefix = 'user_';
    protected $hash_prefix  = 'larabbs_last_actived_at_';

    public function recordLastActivedAt()
    {
//        哈希表
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
//        字段
        $field = $this->getHashField();
//        记录值
        $now = Carbon::now()->toDateTimeString();
        Redis::hset($hash, $field, $now);
    }

    public function SyncUserActivedAt()
    {
        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());

        $data = Redis::hGetAll($hash);

        foreach ($data as $user_id => $actived_at) {
            $user_id = str_replace($this->cache_prefix, '', $user_id);
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        Redis::del($hash);
    }

    public function getHashFromDateString($date)
    {
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
//        user_1
        return $this->cache_prefix . $this->id;
    }

    public function getLastActivedAtAttribute($value)
    {
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        $field = $this->getHashField();
        $datetime = Redis::hGet($hash, $field) ?: $value;

        if ($datetime) {
            return new Carbon($datetime);
        } else {
            return $this->created_at;
        }
    }
}