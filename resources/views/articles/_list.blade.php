@if(isset($articles))
    @foreach($articles as $article)
        <div class="card mb-3">
            <div class="card-header">
                <strong class="topic-date mr-2">{{$article->created_at}}</strong>
                <a class="topic-title" href="{{$article->link()}}">{{$article->title}}</a>
            </div>
            <div class="card-body">
                摘要：{!! $article->excerpt !!}
                <a class="ml-1" href="{{$article->link()}}">阅读全文</a>
            </div>
            <div class="card-footer">
                <small>
                    <span class="mr-2">{{$article->created_at}}</span>
                    <span class="mr-2">阅读：{{$article->view_count}}</span>
                    <span class="mr-2">
                        标签：
                        @foreach($article->tags as $tag)
                            <a class="mr-1 @if(\Request::post('tag_id') == $tag->id) active @endif" href="{{route('root',['tag_id' => $tag->id])}}">{{$tag->name}}</a>
                        @endforeach
                    </span>
                    <span class="mr-2">分类：<a href="{{route('root',['category_id' => $article->category->id])}}">{{$article->category->name}}</a></span>
                </small>
            </div>
        </div>
    @endforeach
@endif