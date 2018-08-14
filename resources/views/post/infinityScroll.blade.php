<div class="infinite-scroll category__container">
    @foreach($posts as $post)
        <article class="category__article">
            <a href="{{url($post->mainCategory->slug . '/' . $post->slug)}}">
                <figure style="background-image:url({{$post->preview}});">
                </figure>
                <figcaption>
                    <h2>{{$post->h1}}</h2>
                    <p class="no-mobile">{{$post->description}}</p>
                </figcaption>
            </a>
        </article>
    @endforeach
</div>
<div class="loader" style="text-align: center; display: none;">
    <img src="{{asset('img/loader.svg')}}" alt="loader"/>
</div>

{{$posts->links()}}

<script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script>
<script>

    //Fix laravel pagination
    var currentPage = document.querySelector('.page-item.active');
    var currentPageText = currentPage.innerText;
    currentPage.innerHTML = '<a class="page-link" href="' + window.location.href + '">' + currentPageText + '</a>';
    var pageItems = document.querySelectorAll('.page-item');
    pageItems[0].remove();
    pageItems[pageItems.length - 1].remove();

    var infScroll = new InfiniteScroll('.category__container', {
        path: function () {
            var currentPage = document.querySelector('.page-item.active');
            var nextPage = currentPage.nextElementSibling;
            if (nextPage) {
                return nextPage.querySelector('.page-link')['href']
            }
        },
        append: '.category__article',
        debug: false,
        history: 'replace',
        historyTitle: true,
        loadOnScroll: false
    });

    infScroll.on('request', function () {
        document.querySelector('.loader').style.display = 'block';
    })

    infScroll.on('load', function () {
        document.querySelector('.loader').style.display = 'none';
    });

    window.onscroll = function (ev) {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            triggerInfiniteScroll()
        }
    };

    function triggerInfiniteScroll() {
        var currentPage = document.querySelector('.page-item.active');
        var nextPage = currentPage.nextElementSibling;
        if (nextPage) {
            infScroll.loadNextPage();
            currentPage.classList.toggle('active');
            nextPage.classList.toggle('active');
        } else {
            var pagination = document.querySelector('.pagination');
            pagination.style.position = 'relative';
            pagination.style.marginBottom = '1em';

        }
    }
</script>