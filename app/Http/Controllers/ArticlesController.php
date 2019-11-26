<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth", ['except' => ['index', 'show']]);
    }

    public function create()
    {
        $categories = Category::pluck('name');
        $tags = Tag::pluck('name');
        return view("articles/create",compact('categories','tags'));
    }

    public function uploadImage()
    {

    }
}
