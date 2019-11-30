<?php


namespace App\Observers;


use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class TagObserver
{
    public function saved(Tag $tag)
    {
        // 清除标签缓存
        Cache::forget($tag->cache_key);
    }
}