<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include('parts.head')
    <body>
        @include('parts.header')
        <main>
            <div class="container">
                @if(isset($categoryTags)) @include('category.tags', ['categoryTags' => $categoryTags]) @endif
                @if(isset($breadCrumbs)) @include('parts.breadCrumbs', ['breadCrumbs' => $breadCrumbs]) @endif
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        @yield('content')
                    </div>
                    @include('parts.aside')
                </div>
            </div>
        </main>
        @include('parts.footer') @include('parts.scripts')
    </body>
</html>