@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="topic-index">
                @include("articles._list",["articles" => $articles])
            </div>
            <p class="text-center"><span class="load">下拉加载更多</span></p>
        </div>

        <!--左侧卡片内容-->
        <div class="col-lg-3 col-md-3 d-none d-sm-block">
            @include("shared._sidebar")
        </div>
    </div>
@stop

@section("scripts")
    <script>
        let page = 1;
        let pageStatus = true;
        $(window).scroll(function () {

            if (!pageStatus || $(".topic-index").children(".card").length < 10) {
                return;
            } else {
                $(".load").show();
            }

            let scrollTop = $(this).scrollTop();
            let scrollHeight = $(document).height();
            let windowHeight = $(this).height();
            if (scrollTop + windowHeight == scrollHeight) {
                page++;
                let url = location.href;
                url = url.replace("?", "?&").split("&");
                //取出域名
                let newUrl = url.shift();
                if (url.length == 0) {
                    newUrl += "?page=" + page;
                } else {
                    //把分页数增加到url数组中
                    url.push("page=" + page);
                    newUrl += url.join("&");
                }

                axios.get(newUrl)
                    .then((response) => {
                        if (response.data == "") {
                            swal("已没有更多数据了")
                            pageStatus = false
                            $(".load").hide();
                        } else {
                            //这里返回的是HTML代码
                            $('.topic-index').append(response.data);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });

                //pageStatus = false;
                alert(page)
                //此处是滚动条到底部时候触发的事件，在这里写要加载的数据，或者是拉动滚动条的操作
                //var page = Number($("#redgiftNextPage").attr('currentpage')) + 1;
                //redgiftList(page);
                //$("#redgiftNextPage").attr('currentpage', page + 1);

            }
        });
    </script>
@endsection