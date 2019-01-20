@extends('layouts.master')
@section('content')
    <main class="posts">
    @foreach($posts as $post)
        <section class="post">
            <a class="post" href="{{ $post->permalink }}">
                @if($post->thumbnail->url)
                <img class="post__thumbnail" src="{{ $post->thumbnail->url }}" alt="{{ $post->title }}">
                @endif
            </a>
            <time class="post__time" datetime="{{ $post->dateTime }}">{{ $post->date }}</time>
            <a class="post__category" href="{{ $post->category->url }}">{{ $post->category->name }}</a>
            <h1 class="post__title">{{ $post->title }}</h1>
        </section>
    @endforeach

    {{  $posts->getPagination() }}
</main>
@endsection