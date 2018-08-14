<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('description')">
    <meta name="copyright" content="Wnews"/>
    <meta property="og:url" content="{{Request::fullUrl()}}"/>
    <meta property="og:site_name" content="{{ config('app.name') }}"/>
    <meta name="twitter:card" content="summary"/>

    @if(isset($metas))
        @foreach($metas as $meta)
            {!! $meta !!}
        @endforeach
    @endif

    <link rel="icon" href="{{asset('img/favicon.png')}}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="canonical" href="{{ URL::current() }}"/>

</head>