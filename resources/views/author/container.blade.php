@php
    /** @var $author \seo_db\Models\Author */
@endphp
@extends('index')
@section('content')
    <div class="authors-list">
        @foreach($authors as $author)
            <div class="authors-list__author">
                <a href="{{url('authors/' . $author->slug)}}">
                    <img src="{{$author->avatar}}"
                         alt="author">
                    <p>{{$author->fullName}}</p>
                </a>
            </div>
        @endforeach
    </div>
@endsection