@extends('index')
@section('content')
    @include('parts.breadCrumbs', ['breadCrumbs' => $breadCrumbs])
    @include('post.content', ['post' => $post])
@endsection