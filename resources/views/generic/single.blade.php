@extends('layouts.master')

@section('content')
    <div class="main-content">
        <article class="article">
            <header class="article__header">
                @if( has_post_thumbnail() )
                    <img src="{{ $post->thumbnail()->url }}" class="post-thumbnail">
                @endif

                <h1 class="text--lg">{{ $post->title }}</h1>
                <time datetime="{{ $post->dateTime }}">{{ $post->post_date }} | {{ $time = get_post_time(get_option('time_format'), false, $post, true) }}</time>
                <span>( By.  {{ $post->author->user_nicename }})</span>
                <span>meta : {{ $post->getMeta('lumen_meta_test') }}</span>

                <h3>Categories</h3>

                @foreach($post->categories() as $category)
                    <span>{{ $category->name }}</span>
                @endforeach

            </header>

            <div class="article__content">
                {!! $post->content() !!}
            </div>
        </article>
    </div>
@endsection