<div class="articles__container">
    <article class="article">
        <h1>{{$post->h1}}</h1>
        <span class="news-meta">
                    <time datetime="{{$post->created_at->format('Y-m-d\TH:i:s.uP')}}">
                        <span>{{$post->created_at->format('Y-m-d')}}</span>
                    </time>
                    <span>by <a href="{{url('authors/' . $post->author->slug)}}" class="author"
                                rel="nofollow">
                        <span>{{$post->author->fullName}}</span>
                        </a>
                    </span>
                </span>

        {!! $post->content !!}

        <footer>
            {{--CATEGORIES--}}
            <div class="article__categories">
                                <span>
                                    <strong>Категории: </strong>
                                </span>
                <ul class="comma-list">
                    @foreach($post->categories as $category)
                        <li>
                            <a href="{{url($category->slug)}}">{{$category->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            {{--TAGS--}}
            <div class="article__tags">
                                <span>
                                    <strong>Tags: </strong>
                                </span>
                <ul class="comma-list">
                    @foreach($post->tags as $tag)
                        <li>
                            <a href="{{url('tag/' . $tag->slug)}}">{{$tag->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </footer>
        @if(isset($nextPost))
            <a class="pagination__next"
               href="{{url($nextPost->mainCategory->slug . '/' . $nextPost->slug)}}">Next</a>
        @endif
    </article>
</div>