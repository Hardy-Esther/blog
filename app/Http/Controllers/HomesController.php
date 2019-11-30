<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomesController extends Controller
{
    public function index(Request $request, Article $article)
    {

        $tag_id = $request->tag_id;

        $articles = $article
            ->withOrder($request->order)
            ->when($tag_id, function ($query) use ($tag_id) {
                return $query->Join('article_tags', 'articles.id', 'article_id')
                    ->where('tag_id', $tag_id);
            })
            ->paginate(10);
        if ($request->ajax()) {
            return view("articles/_list", compact("articles"));
        }
        return view("homes/index", compact("articles"));
    }
}
