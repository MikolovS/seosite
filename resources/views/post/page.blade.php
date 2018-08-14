@extends('index')
@section('content')
    @include('post.content', ['post' => $post])

    <script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script>
    <script>
        var infScroll = new InfiniteScroll('.articles__container', {
            path: function () {
                var links = document.querySelectorAll('.pagination__next');
                var nextLink = links[links.length - 1];
                if (nextLink && window.location.href !== nextLink['href']) {
                    return nextLink['href'];
                }
            },
            append: '.article',
            debug: false,
            history: 'replace',
            historyTitle: true
        });
    </script>
@endsection