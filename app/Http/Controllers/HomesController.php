<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Http\Request;

class HomesController extends Controller
{
    public function index(Request $request, Article $article)
    {

        $tag_id = $request->tag_id;
        if ($tag_id) {
            $article_ids = ArticleTag::where('tag_id', $tag_id)->pluck('article_id')->toArray();
            empty($article_ids) && $article_ids[] = -1;
        } else {
            $article_ids = false;
        }
        $articles = $article
            ->withOrder($request->order)
            ->where('is_draft',false)
            ->when($article_ids, function ($query) use ($article_ids) {
                return $query->whereIn('id', $article_ids);
            })
            ->paginate(10);

        if ($request->ajax()) {
            return view("articles/_list", compact("articles"));
        }
        return view("homes/index", compact("articles"));
    }
}
