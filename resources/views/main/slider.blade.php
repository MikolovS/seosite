@php
    /**
     * @var $sliderPost \seo_db\Models\Post
     * @var $newsPost \seo_db\Models\Post
    */
@endphp
<div id="hero-slider" class="no-mobile">
    <swiper ref="awesomeSwiper" :options="swiperOptions">
        @foreach($sliderContent as $sliderPost)
            <swiper-slide class="hero">
                <a href="{{url($sliderPost->mainCategory->slug . '/' . $sliderPost->slug)}}">
                    <figure style="background-image:url({{$sliderPost->preview}});"></figure>
                    <figcaption>
                        <h2>{{$sliderPost->h1}}</h2>
                    </figcaption>
                </a>
            </swiper-slide>
        @endforeach
        <div class="swiper-pagination" slot="pagination"></div>
    </swiper>
</div>
<h2 class="text-red">Noticias</h2>
<div id="news-slider">
    <swiper ref="awesomeSwiper" :options="swiperOptions">
        @foreach($newsSliderContent as $newsPost)
            <swiper-slide class="news">
                <a href="{{url($newsPost->mainCategory->slug . '/' . $newsPost->slug)}}">
                    <figure style="background-image:url({{$newsPost->preview}});">
                    </figure>
                    <figcaption>
                        <h2>{{$newsPost->h1}}</h2>
                    </figcaption>
                </a>
            </swiper-slide>
        @endforeach
        <div class="swiper-button-prev swiper-button-black" slot="button-prev"></div>
        <div class="swiper-button-next swiper-button-black" slot="button-next"></div>
    </swiper>
</div>