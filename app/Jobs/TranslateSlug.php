<?php

namespace App\Jobs;

use App\Handlers\SlugTranslateHandler;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $article;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        // 队列任务构造器中接收了 Eloquent 模型，将会只序列化模型的 ID
        $this->article = $article;
    }

    public function handle()
    {
        // 请求百度 API 接口进行翻译
        $slug = app(SlugTranslateHandler::class)->translate($this->article->title);

        // 为了避免模型监控器死循环调用，我们使用 DB 类直接对数据库进行操作
        \DB::table('articles')->where('id', $this->article->id)->update(['slug' => $slug]);
    }
}
