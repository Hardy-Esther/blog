<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', '首页') - Hardy'Blog</title>

    <meta name="description" content="@yield('description', "Hardy'Blog 编程、算法学习分享")"/>
    <meta name="keyword" content="@yield('keyword', "Hardy'Blog 编程、算法学习分享")"/>
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- 引用liv2D -->
    <link rel="stylesheet" type="text/css" href="{{asset("live2d/assets/waifu.css")}}" />

    @yield('styles')
</head>

<body>
<div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="container content">

        @include('shared._messages')

        @yield('content')

    </div>

    @include('layouts._footer')
</div>

<!-- live2D -->
<div class="waifu">
    <div class="waifu-tips"></div>
    <canvas id="live2d" width="280" height="300" class="live2d"></canvas>
    <div class="waifu-tool">
        <span class="fui-home"></span>
        <span class="fui-chat"></span>
        <span class="fui-eye"></span>
        <span class="fui-user"></span>
        <span class="fui-photo"></span>
        <span class="fui-info-circle"></span>
        <span class="fui-cross"></span>
    </div>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<!-- 引用liv2D -->
<script src="{{asset("live2d/assets/waifu-tips.js")}}"></script>
<script src="{{asset("live2d/assets/live2d.js")}}"></script>
<script type="text/javascript">
    initModel("{{asset("live2d/assets/")}}");
</script>

@yield("scripts")
<script>
    $(document).ready(function () {
        $("#logout").click(function () {
            swal({
                text: "您确定要退出吗？",
                buttons: ['取消', '确定'],
            }).then((value) => {
                if (!value) {
                    return;
                }
                axios({
                    url: '{{route("logout")}}',
                    method: 'post',
                    data: {
                        _token: "{{csrf_token()}}"
                    }
                }).then((res) => {
                    location.reload();
                });
            });
        });
    })
</script>
</body>

</html>