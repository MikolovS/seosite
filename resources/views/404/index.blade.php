<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include('parts.head')
    <body>
        <section id="page-404">
        <div class="hero">
            <img src="{{asset('img/404.svg')}}" alt="404"/>
            <h2>OPPS, WE HAVE AN ERROR</h2>
            <a href="/">GO BACK</a>
        </div>
        </section>
    </body>
</html>
