<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{

    public function store(Request $request, Tag $tag)
    {
        if ($tag->where("name", $request->name)->first()) {
            return $this->error("该标签已存在");
        }
        $tag->fill($request->all());
        $tag->save();
        return $this->success("创建标签成功",$tag);
    }
}
