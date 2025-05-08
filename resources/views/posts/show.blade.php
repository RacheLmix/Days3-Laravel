@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mb-4">
                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary">&larr; Back to all posts</a>
            </div>
            
            <article>
                <h1>{{ $post->title }}</h1>
                
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <span class="text-muted">By: <a href="{{ route('posts.by-author', $post->author->id) }}">{{ $post->author->name }}</a></span>
                    </div>
                    <div>
                        <span class="badge bg-{{ $post->status === 'published' ? 'success' : ($post->status === 'draft' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($post->status) }}
                        </span>
                        @if($post->published_at)
                            <span class="text-muted ml-2">Published: {{ $post->published_at }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="post-content">
                    {!! $post->content !!}
                </div>
            </article>
        </div>
    </div>
</div>
@endsection