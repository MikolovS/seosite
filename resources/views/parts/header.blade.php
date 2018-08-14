<?php
declare( strict_types = 1 );
/** @var \Kalnoy\Nestedset\Collection $navCategories */
$navCategories = \App\Services\NavBar\NavBarService::make()->getCategoryTree();
?>
<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="header__hero">
                    <button class="header__menu-button only-mobile" @click="toggleMobileMenu">
                        <i class="wsi-menu"></i>
                    </button>
                    <a href="{{url('')}}" class="header__logo">
                        <img src="{{asset('img/logo.svg')}}" alt="logo">
                    </a>
                    <ul class="header__socials no-mobile">
                        <li class="header__icon header__icon-facebook">
                            <a href="https://www.facebook.com/womensnewsespanol/" target="_blank">
                                <i class="wsi-facebook"></i>
                            </a>
                        </li>
                        <li class="header__icon header__icon-twitter">
                            <a href="https://twitter.com/EspanolWomen" target="_blank">
                                <i class="wsi-twitter"></i>
                            </a>
                        </li>
                        <li class="header__icon header__icon-instagram">
                            <a href="#" target="_blank">
                                <i class="wsi-instagram"></i>
                            </a>
                        </li>
                        <li class="header__icon header__icon-pinterest">
                            <a href="https://www.pinterest.ru/WNewsEspanol/" target="_blank">
                                <i class="wsi-pinterest"></i>
                            </a>
                        </li>
                        <li class="header__icon header__icon-gplus">
                            <a href="https://plus.google.com/u/1/102849817135150964249" target="_blank">
                                <i class="wsi-gplus"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <nav class="header__nav no-mobile">
                    <ul>
                        @foreach($navCategories as $category)
                            <li class="header__nav-dropdown">
                                <a class="{{Request::is([$category->slug . '/*', $category->slug]) ? 'active' : ''}}"
                                    href="{{url($category->slug)}}">{{$category->name}}</a>
                                @if($category->children->isNotEmpty())
                                    <ul>
                                        @foreach($category->children as $subCategory)
                                            <li>
                                                <a href="{{url($subCategory->slug)}}">{{$subCategory->name}}</a>
                                                @if($subCategory->children->isNotEmpty())
                                                    <ul>
                                                        @foreach($subCategory->children as $cat)
                                                            <li>
                                                                <a href="{{url($cat->slug)}}">{{$cat->name}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>
                <transition name="fade">
                    <nav class="container" id="mobile-menu" v-if="mobileMenu">
                        <ul>
                            @foreach($navCategories as $category)
                                <li>
                                    <a href="{{url($category->slug)}}">{{$category->name}}</a>
                                    @if($category->children->isNotEmpty())
                                        <i class="wsi-add" @click="showSub($event)"></i>
                                        <ul>
                                            @foreach($category->children as $subCategory)
                                                <li>
                                                    <a href="{{url($subCategory->slug)}}">{{$subCategory->name}}</a>
                                                    @if($subCategory->children->isNotEmpty())
                                                        <i class="wsi-add" @click="showSub($event)"></i>
                                                        <ul>
                                                            @foreach($subCategory->children as $cat)
                                                                <li>
                                                                    <a href="{{url($cat->slug)}}">{{$cat->name}}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </transition>
            </div>
        </div>
    </div>
</header>
