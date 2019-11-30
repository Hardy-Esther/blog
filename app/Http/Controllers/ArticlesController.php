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

    public function show(Request $request, Article $article)
    {

        if (!empty($article->slug) && $article->slug != $request->slug) {
            return redirect($article->link(), 301);
        }
        //阅读数加1
        $article->readAddNum();
        return view("articles/show", compact('article'));
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        $categories = Category::select("id", "name")->get();
        $tags = Tag::select("id", "name")->get();
        $tag_ids = $article->tags()->allRelatedIds()->toArray();
        return view("articles/edit", compact('article', 'categories', 'tags', 'tag_ids'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);
        $article->update($request->all());
        //关联标签
        if ($tag_ids = $request->get('tag_ids')) {
            //先移除该文章的所有标签
            $article->tags()->detach();
            //再关联回来新的标签
            $article->tags()->sync($tag_ids, false);
        }


        return redirect()->to($article->link())->with('success', '文章更新成功！');
    }

    public function destroy(Article $article)
    {
        $this->authorize('destroy', $article);
        //先移除该文章的所有标签
        $article->tags()->detach();
        $article->delete();

        return $this->success("删除成功！");
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
