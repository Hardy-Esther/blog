<!--页头-->
<div class="header">
    <div class="header-bg">
        <div class="blog-title">
            <div class="container">
                <h1>Hardy'Blog</h1>
                <h5>每个人都在寻找自己；少部分的人找到了，大部分的人还在寻找的路上</h5>
            </div>
        </div>
    </div>
    <nav class="navbar-expand-lg bg-black">
        <div class="container">
            <ul id="nav-list">
                <li class="nav-item {{ active_class(if_route('root')) }}"><a href="{{route('root')}}">首页</a></li>
                <li class="nav-item {{ category_nav_active(1) }}"><a href="{{route('categories.show',1)}}">编程</a></li>
                <li class="nav-item {{ category_nav_active(2) }}"><a href="{{route('categories.show',2)}}">算法</a></li>
                {{--<li class="nav-item"><a href="javascript:;">留言</a></li>--}}
            </ul>
        </div>
    </nav>
</div>