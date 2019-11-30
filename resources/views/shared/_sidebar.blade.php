@auth
    <div class="card mb-3">
        <div class="card-header card-title"><strong>{{Auth::user()->name}}</strong></div>
        <div class="card-body">
            <p>
                <a href="{{ route('articles.create') }}" class="btn btn-primary" role="button" style="width: 100%">
                    创建文章
                </a>
            </p>
            <p><button type="button" class="btn btn-danger" id="logout" style="width: 100%">退出登陆</button></p>
        </div>
    </div>
@endauth
<div class="card mb-3">
    <div class="card-header card-title"><strong>个人简介</strong></div>
    <div class="card-body">
        <p class="text">姓名：<a href="https://github.com/Hardy-Esther" target="_blank">张武军(Hardy)</a></p>
        <p class="text">简介：码农、web程序员</p>
        <p><img src="{{ asset("image/wechat.jpg") }}" width="100%"></p>
    </div>
</div>
@if($tags = (new \App\Models\Tag())->getAllCached())
<div class="card mb-3">
    <div class="card-header card-title"><strong>文章标签</strong></div>
    <div class="card-body">
        @foreach($tags as $tag)
            <a href="{{route('root',['tag_id' => $tag->id])}}" class="mr-1"><span class="tag badge badge-{{tag_class($tag->id)}}">{{$tag->name}}</span></a>
        @endforeach
    </div>
</div>
@endif
@if($article_hot = (new \App\Models\Article())->hot())
<div class="card mb-3">
    <div class="card-header card-title"><strong>阅读排行榜</strong></div>
    <div class="card-body">
        <ul class="nav">
            @foreach($article_hot as $index => $hot)
            <li class="nav-item">
                <a href="{{$hot->link()}}">{{$index+1}}. {{$hot->title}}<span class="badge badge-info ml-1">{{$hot->view_count}}</span></a>
                @if ( ! $loop->last)
                    <hr>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif