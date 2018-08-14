@php
    /** @var $author \seo_db\Models\Author */
@endphp
@extends('index')
@section('content')
    <div class="author">
        <div class="author-contacts">
            <img src="{{$author->avatar}}"
                 alt="author">
            <p>
                <strong>Местоположение</strong>
            </p>
            <p>{{$author->office}}</p>
            <p>
                <strong>Номер телефона</strong>
            </p>
            <p>{{$author->phone}}</p>
            <p>
                <strong>Период сотрудничества</strong>
            </p>
            <p>{{$author->partnership}}</p>
        </div>
        <div class="author-info">
            <p class="position">{{$author->position}}</p>
            <p class="name">{{$author->fullName}}</p>
            <p class="bio">Bio</p>
            <div class="author-bio">
                {!! $author->description !!}
            </div>
            <ul class="author-socials">
                @if($author->facebook)
                    <li class="author__icon-facebook">
                        <a href="https://www.facebook.com/{{$author->facebook}}" target="_blank">
                            <i class="wsi-facebook"></i>
                        </a>
                    </li>
                @endif
                @if($author->twitter)
                    <li class="author__icon-twitter">
                        <a href="https://twitter.com/{{$author->twitter}}" target="_blank">
                            <i class="wsi-twitter"></i>
                        </a>
                    </li>
                @endif
                @if($author->instagram)
                    <li class="author__icon-instagram">
                        <a href="https://instagram.com/{{$author->instagram}}" target="_blank">
                            <i class="wsi-instagram"></i>
                        </a>
                    </li>
                @endif
                @if($author->pinterest)
                    <li class="author__icon-pinterest">
                        <a href="https://www.pinterest.ru/{{$author->pinterest}}" target="_blank">
                            <i class="wsi-pinterest"></i>
                        </a>
                    </li>
                @endif
                @if($author->google)
                    <li class="author__icon-gplus">
                        <a href="https://plus.google.com/{{$author->google}}" target="_blank">
                            <i class="wsi-gplus"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    @include('post.infinityScroll', ['posts' => $posts])
@endsection