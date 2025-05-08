@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-4">
                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary">&larr; Back to all posts</a>
            </div>
            
            <div class="author-info mb-4">
                <h1>Posts by {{ $author->name }}</h1>
                @if($author->bio)
                    <div class="author-bio">
                        <p>{{ $author->bio }}</p>
                    </div>
                @endif
            </div>
            
            @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
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
                    This author has no published posts.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection