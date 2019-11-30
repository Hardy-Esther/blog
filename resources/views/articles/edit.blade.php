@extends('layouts.app')
@section('title', '创建文章')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-create">
            <div class="card ">
                <div class="card-header">
                    <h3 class="text-center mt-1">编辑文章</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("articles.update", $article->id) }}" method="POST" accept-charset="UTF-8">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input class="form-control" type="text" name="title" value="{{ $article->title }}" placeholder="请填写标题" required/>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="category_id" required>
                                <option value="" hidden disabled selected>请选择分类</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if($category->id == $article->category_id) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control tags" name="tag_ids[]" required multiple="multiple" style="width: calc(100% - 110px)">
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}" @if(in_array($tag->id,$tag_ids)) selected @endif>{{$tag->name}}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary ml-1" type="button" id="creteTag">创建新标签
                            </button>
                        </div>
                        <div class="form-group">
                            <textarea name="excerpt" class="form-control" rows="3" placeholder="请填入一小段文章摘要。"
                                      required>{!! $article->excerpt !!}</textarea>
                        </div>
                        <div class="form-group">
                            <textarea name="body" class="form-control" id="editor" rows="6" placeholder="请填入至少三个字符的内容。"
                                      required>{!! $article->body !!}</textarea>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" @if($article->is_draft) checked @endif value="1" name="is_draft">是否存为草稿
                            </label>
                        </div>

                        <div class="well well-sm mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="far fa-save mr-2" aria-hidden="true"></i> 保存
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!--左侧卡片内容-->
        <div class="col-lg-3 col-md-3 d-none d-sm-block">
            @include("shared._sidebar")
        </div>
    </div>
@endsection

@section("styles")
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("css/select2.min.css") }}">
@endsection
@section("scripts")
    <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

    <script>


        $(document).ready(function () {
            var editor = new Simditor({
                textarea: $('#editor'),
                upload: {
                    url: '{{ route('articles.upload_image') }}',
                    params: {
                        _token: '{{ csrf_token() }}'
                    },
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '文件上传中，关闭此页面将取消上传。'
                },
                pasteImage: true,
            });
            $(".tags").select2({
                placeholder: "请选择一个或多个标签",
                minimumResultsForSearch: -1,// 不展示搜索框
            });
            $("#creteTag").click(function (e) {
                swal("创建的标签名称:", {
                    content: "input",
                    buttons: ['取消', '确定'],
                    dangerMode: true,
                }).then((value) => {
                    if (!value) {
                        return;
                    }

                    axios({
                        url: '{{route("tags.store")}}',
                        method: 'post',
                        data: {
                            name: value,
                            _token: "{{csrf_token()}}"
                        }
                    }).then((res)=>{
                        if(res.status == 200){
                            var data = res.data.data;
                            var newOption = new Option(data.name, data.id, false, true);
                            $('.tags').append(newOption).trigger('change');
                            swal("创建"+data.name+"标签成功");
                        }else{
                            swal("创建标签失败");
                        }
                    });
                });
            });
        })
        ;


    </script>
@endsection