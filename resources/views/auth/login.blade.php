<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>登陆 - Hardy'Blog</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>

<div id="particles-js" class="login-page">
    <div class="login">
        <div class="login-top">
            登录
        </div>
        <div class="login-center clearfix">
            <div class="login-center-img"><img src="image/name.png"></div>
            <div class="login-center-input">
                <input
                        type="text"
                        name="username"
                        value="" placeholder="请输入您的用户名"
                        onfocus="this.placeholder=&#39;&#39;"
                        onblur="this.placeholder=&#39;请输入您的用户名&#39;"
                >
                <div class="login-center-input-text">用户名</div>
            </div>
        </div>
        <div class="login-center clearfix">
            <div class="login-center-img"><img src="image/password.png"></div>
            <div class="login-center-input">
                <input
                        type="password"
                        name="password"
                        value=""
                        placeholder="请输入您的密码"
                        onfocus="this.placeholder=&#39;&#39;"
                        onblur="this.placeholder=&#39;请输入您的密码&#39;"
                >
                <div class="login-center-input-text">密码</div>
            </div>
        </div>
        <div class="login-button">
            登陆
        </div>
    </div>
    <div class="sk-rotating-plane"></div>
    <canvas id="canvas" width="1680" height="939" style="width: 100%; height: 100%;"></canvas>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="js/word.js"></script>
<script src="js/canvas.js"></script>
<script>
    function hasClass(elem, cls) {
        cls = cls || '';
        if (cls.replace(/\s/g, '').length == 0) return false; //当cls没有参数时，返回false
        return new RegExp(' ' + cls + ' ').test(' ' + elem.className + ' ');
    }

    function addClass(ele, cls) {
        if (!hasClass(ele, cls)) {
            ele.className = ele.className == '' ? cls : ele.className + ' ' + cls;
        }
    }

    function removeClass(ele, cls) {
        if (hasClass(ele, cls)) {
            var newClass = ' ' + ele.className.replace(/[\t\r\n]/g, '') + ' ';
            while (newClass.indexOf(' ' + cls + ' ') >= 0) {
                newClass = newClass.replace(' ' + cls + ' ', ' ');
            }
            ele.className = newClass.replace(/^\s+|\s+$/g, '');
        }
    }

    document.querySelector(".login-button").onclick = function () {

        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();

        if (username == "" || password == "") {
            alert("用户名和密码都不能为空");
        }
        addClass(document.querySelector(".login"), "active")
        $.ajax({
            type: "POST",
            url: "/login",
            data: {
                name: username,
                password: password,
                _token: '{{ csrf_token() }}'
            },
            dataType: "json",
            success: function (data) {
                removeClass(document.querySelector(".login"), "active");
                removeClass(document.querySelector(".sk-rotating-plane"), "active");
                document.querySelector(".login").style.display = "block";

                if(data.status == true){
                    swal({text: data.msg, icon: "success", button: "确定"})
                        .then((value) => {
                            window.location.href = "/";
                        });
                }else{
                    swal({text: data.msg, icon: "error", button: "确定"});
                }

            },
            error: function (e) {
                removeClass(document.querySelector(".login"), "active");
                removeClass(document.querySelector(".sk-rotating-plane"), "active");
                document.querySelector(".login").style.display = "block";
                swal({text: "登陆失败！", icon: "error", button: "确定"});
            }
        });
    }
</script>
</body>
</html>
