<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'body',
        'excerpt',
        'slug',
        'is_draft',
    ];

    protected $casts = [
        'is_draft' => 'boolean',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::Class, 'article_tags');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function readAddNum($num = 1)
    {
        return $this->increment('view_count', $num);
    }

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            case 'view':
                $query->view();
                break;
            default:
                $query->recent();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user', 'category', 'tags');
    }

    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeView($query)
    {
        // 按照创建时间排序
        return $query->orderBy('view_count', 'desc');
    }

    public function link($params = [])
    {
        return route('articles.show', array_merge([$this->id, $this->slug], $params));
    }

    public function hot()
    {
        return $this->select('id', 'title', 'slug', 'view_count')->view()->where('is_draft', false)->limit(10)->get();
    }

}
