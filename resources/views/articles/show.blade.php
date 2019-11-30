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
                @can('update', $article)
                    <div class="card-footer">
                        <div class="operate">
                            <hr>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary btn-sm"
                               role="button">
                                <i class="far fa-edit"></i> 编辑
                            </a>
                            <button type="button" data-id="{{$article->id}}" class="btn btn-danger btn-sm ml-2"
                                    id="articles-delete">
                                <i class="far fa-trash-alt"></i> 删除
                            </button>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
        <!--左侧卡片内容-->
        <div class="col-lg-3 col-md-3 d-none d-sm-block">
            @include("shared._sidebar")
        </div>
    </div>
@endsection

@section("scripts")
    <script>
        $(document).ready(function () {
            // 删除按钮点击事件
            $("#articles-delete").click(function () {
                var id = $(this).data('id');
                // 调用 sweetalert
                swal({
                    title: "确认要该文章？",
                    icon: "warning",
                    buttons: ['取消', '确定'],
                    dangerMode: true,
                }).then(function (willDelete) { // 用户点击按钮后会触发这个回调函数
                    // 用户点击确定 willDelete 值为 true， 否则为 false
                    // 用户点了取消，啥也不做
                    if (!willDelete) {
                        return;
                    }
                    // 调用删除接口，用 id 来拼接出请求的 url
                    axios.delete('/articles/' + id)
                        .then(function () {
                            // 请求成功之后重新加载页面
                            swal({text: "删除文章成功！", icon: "success", button: "确定"})
                                .then((value) => {
                                    window.history.back(-1);
                                });
                        })
                });
            });
        })
    </script>
@endsection