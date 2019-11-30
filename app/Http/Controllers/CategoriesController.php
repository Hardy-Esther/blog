<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Article $article)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $articles = $article->withOrder($request->order)
            ->where('category_id', $category->id)
            ->paginate(10);

        if ($request->ajax()) {
            return view("articles/_list", compact("articles"));
        }
        return view("homes/index", compact("articles","category"));

    }
}
