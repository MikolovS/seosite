@extends('index')
@section('content')
    @if($sliderContent->isNotEmpty())
        @include('main.slider', ['sliderContent' => $sliderContent, 'newsSliderContent' => $newsSliderContent])
    @endif
    @foreach($categories as $category)
        <section class="category-row">
            <span class="category-title">
                <span class="no-mobile">Últimos artículos de</span>
                <span class="category-title-name">
                    <strong>{{$category->name}}</strong>
                </span>
                <a href="{{url($category->slug)}}" rel="nofollow">Ver todos
                    <i class="wsi-keyboard_arrow_right"></i>
                </a>
            </span>
            <article class="article article-fullwidth">
                <a href="{{url($category->slug . '/' . $category->previewPost->slug)}}"
                   title="{{$category->previewPost->h1}}">
                    <figure style="background-image:url({{$category->previewPost->preview}});">
                    </figure>
                    <figcaption>
                        <h2>{{$category->previewPost->h1}}</h2>
                        <p class="no-mobile">{{$category->previewPost->description}}</p>
                    </figcaption>
                </a>
            </article>
            @foreach($category->mainPosts as $post)
                <article class="article">
                    <a href="{{url($category->slug . '/' . $post->slug)}}" title="{{$post->h1}}">
                        <figure style="background-image:url({{$post->preview}});">
                        </figure>
                        <figcaption>
                            <h2>{{$post->h1}}</h2>
                        </figcaption>
                    </a>
                </article>
            @endforeach
        </section>
    @endforeach
@endsection