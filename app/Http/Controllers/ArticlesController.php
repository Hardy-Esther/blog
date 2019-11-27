<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
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
        $categories = Category::select("id", "name")->get();
        $tags = Tag::select("id", "name")->get();

        return view("articles/create", compact('categories', 'tags'));
    }

    public function store(ArticleRequest $request, Article $article)
    {

        $article->fill($request->all());
        $article->user_id = \Auth::id();
        $article->save();
        //关联标签
        if ($tag_ids = $request->get('tag_ids')) {
            $article->tags()->sync($tag_ids, false);
        }

        return redirect()->to($article->link())->with('success', '成功文章话题！');
    }

    public function show(Article $article)
    {
        return view("articles/show",compact('article'));
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }
        return $data;
    }
}
