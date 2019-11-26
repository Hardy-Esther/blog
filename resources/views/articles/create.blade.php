@extends('layouts.app')
@section('title', '创建文章')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-create">
            <div class="card ">
                <div class="card-header">
                    <h3 class="text-center mt-1">创建文章</h3>
                </div>
                <div class="card-body">
                    <form action="#" method="POST" accept-charset="UTF-8">

                        <div class="form-group">
                            <input class="form-control" type="text" name="title" value="" placeholder="请填写标题" required />
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="category_id" required>
                                <option value="" hidden disabled selected>请选择分类</option>
                                <option value="1">编程</option>
                                <option value="2">算法</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control tags" name="tag_ids" required multiple="multiple" style="width: calc(100% - 110px)">
                                <option value="1">编程</option>
                                <option value="2">算法</option>
                            </select>
                            <button class="btn btn-primary ml-1" type="button" data-toggle="modal" data-target="#creteTag">创建新标签</button>
                        </div>
                        <div class="form-group">
                            <textarea name="excerpt" class="form-control" rows="3" placeholder="请填入一小段文章摘要。" required></textarea>
                        </div>
                        <div class="form-group">
                            <textarea name="body" class="form-control" id="editor" rows="6" placeholder="请填入至少三个字符的内容。" required></textarea>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                 <input class="form-check-input" type="checkbox" name="is_draft">是否存为草稿
                            </label>
                        </div>

                        <div class="well well-sm mt-2">
                            <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
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

    <!-- 模态框 -->
    <div class="modal fade" id="creteTag" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- 模态框头部 -->
                <div class="modal-header">
                    <h4 class="modal-title">模态框头部</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- 模态框主体 -->
                <div class="modal-body">
                    模态框内容..
                </div>

                <!-- 模态框底部 -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">创建</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                </div>

            </div>
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

        $(document).ready(function() {
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
        });
        $(".tags").select2({
            placeholder: "请选择一个或多个标签",
            minimumResultsForSearch : -1,// 不展示搜索框
        });
        $('#creteTag').on('shown.bs.modal', function (e) {
            // 关键代码，如没将modal设置为 block，则$modala_dialog.height() 为零
            $(this).css('display', 'block');
            var modalHeight=$(window).height() / 2 - $('#creteTag .modal-dialog').height() / 2;
            $(this).find('.modal-dialog').css({
                'margin-top': modalHeight
            });
        });

    </script>
@endsection