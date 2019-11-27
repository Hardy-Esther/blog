@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->excerpt)

@section('content')
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-details">
            <div class="card mb-3">
                <div class="card-header mt-3">
                    <h3 class="text-center mt-1">{{$article->title}}</h3>
                    <small class="mt-2">
                        <span class="mr-2">{{$article->created_at}}</span>
                        <span class="mr-2">阅读：{{$article->view_count}}</span>
                        <span class="mr-2">
                            标签：
                                @foreach($article->tags as $tag)
                                    <a class="mr-1" href="javascript:;">{{$tag->name}}</a>
                                @endforeach
                        </span>
                        <span class="mr-2">分类：<a href="javascript:;">{{$article->category->name}}</a></span>
                    </small>
                </div>
                <div class="card-body topic-body">
                    {!! $article->body !!}
                </div>

                <div class="card-footer">
                    <div class="operate">
                        <hr>
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary btn-sm" role="button">
                            <i class="far fa-edit"></i> 编辑
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm ml-2">
                            <i class="far fa-trash-alt"></i> 删除
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <!--左侧卡片内容-->
        <div class="col-lg-3 col-md-3 d-none d-sm-block">
            @include("shared._sidebar")
        </div>
    </div>
@endsection