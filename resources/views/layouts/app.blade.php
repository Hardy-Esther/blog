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

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
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