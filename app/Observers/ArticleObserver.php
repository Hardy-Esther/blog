<?php


namespace App\Observers;


use App\Jobs\TranslateSlug;
use App\Models\Article;

class ArticleObserver
{
    public function saving(Article $article)
    {
        // XSS 过滤
        $article->body = clean($article->body, 'user_article_body');

        // 生成话题摘录
        $article->excerpt = strip_tags($article->excerpt);
    }

    public function saved(Article $article)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $article->slug) {
            // 推送任务到队列
            dispatch(new TranslateSlug($article));
        }
    }

}