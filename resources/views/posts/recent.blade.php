@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-4">
                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary">&larr; Back to all posts</a>
            </div>
            
            <h1>Recent Posts (Last 30 Days)</h1>
            
            @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">By: <a href="{{ route('posts.by-author', $post->author->id) }}">{{ $post->author->name }}</a></h6>
                                    <p class="card-text">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">{{ $post->created_at->format('d/m/Y') }}</span>
                                        <a href="{{ route('posts.show', $post->slug) }}" class="card-link">Read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No recent posts found.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection